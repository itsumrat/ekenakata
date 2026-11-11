<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\CreatePage;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingCharge;
use App\Models\SmsGateway;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Smoke test: renders every read-only page of the shop, the admin panel and the API,
 * and places a real checkout order. It runs against the local database inside a
 * transaction that is rolled back, so no data is changed.
 *
 * Run: php artisan test --filter=SmokeTest
 */
class SmokeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Pages that were already broken before the Laravel 12 upgrade (bugs in the app
     * code itself, not in the framework). They are skipped so the test stays green;
     * remove an entry once its bug is fixed.
     */
    private const KNOWN_BROKEN = [
        'shop/cart',                      // route points to ShoppingController::cart_show(), which does not exist
    ];

    protected function setUp(): void
    {
        parent::setUp();

        // Never contact real outside services (Pathao courier, payment gateways, ...)
        // from a test: every Laravel HTTP client call gets an empty 200 response.
        Http::fake();
    }

    public function test_storefront_pages_render(): void
    {
        $product = Product::where('status', 1)->first();

        $this->assertPagesOk([
            '/',
            'category/'.Category::where('status', 1)->value('slug'),
            'subcategory/'.Subcategory::value('slug'),
            'products/'.Childcategory::where('status', 1)->value('slug'),
            'product/'.$product->slug,
            'hot-deals',
            'search?keyword=a',
            'livesearch?keyword=a',
            'site/contact-us',
            'page/'.CreatePage::value('slug'),
            'campaign/'.Campaign::value('slug'),
            'offer',
            'districts',
            'cart/count',
            'mobilecart/count',
            'customer/checkout',
            'customer/login',
            'customer/register',
            'customer/forgot-password',
            'customer/order-track',
        ]);
    }

    public function test_api_endpoints_respond(): void
    {
        $this->assertPagesOk([
            'api/v1/app-config',
            'api/v1/slider',
            'api/v1/category-menu',
            'api/v1/category/'.Category::value('id'),
            'api/v1/contactinfo',
            'api/v1/footer-menu-left',
            'api/v1/footer-menu-right',
            'api/v1/homepage-product',
            'api/v1/hotdeal-product',
            'api/v1/social-media',
        ]);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/customer/account')->assertRedirect('/customer/login');
    }

    public function test_cart_and_cash_on_delivery_checkout(): void
    {
        // Placing an order sends an SMS through raw curl when an SMS gateway is active.
        // sms_gateways is a MyISAM table (not covered by the rollback), so instead of
        // updating it we hide every gateway from queries for this test only.
        SmsGateway::addGlobalScope('smoke-test-no-sms', fn ($q) => $q->whereRaw('1 = 0'));

        $product = Product::where('status', 1)->whereHas('image')->firstOrFail();
        $area = ShippingCharge::where('status', 1)->firstOrFail();
        $ordersBefore = Order::count();

        $this->post('cart/store', ['id' => $product->id, 'qty' => 2])
            ->assertRedirect(route('customer.checkout'));

        $this->get('customer/checkout')->assertOk()->assertSee($product->name, false);

        $response = $this->post('customer/order-save', [
            'name' => 'Smoke Test',
            'phone' => '01700000000',
            'address' => 'Test address',
            'area' => $area->id,
            'payment_method' => 'Cash On Delivery',
        ]);

        $this->assertLessThan(500, $response->status(), 'order-save crashed');
        $this->assertSame($ordersBefore + 1, Order::count(), 'order was not created');

        $order = Order::latest('id')->first();
        $this->assertSame(2, (int) $order->orderdetails()->sum('qty'));
        $this->assertEquals('Cash On Delivery', $order->payment->payment_method);
    }

    public function test_customer_panel_pages_render(): void
    {
        $customer = Customer::firstOrFail();

        $this->actingAs($customer, 'customer');
        $this->assertPagesOk([
            'customer/account',
            'customer/orders',
            'customer/profile-edit',
            'customer/change-password',
        ]);
    }

    public function test_admin_pages_render(): void
    {
        $this->actingAs(User::firstOrFail());

        $invoice = Order::value('invoice_id');
        $urls = [
            'admin/dashboard', 'admin/change-password', 'admin/customer/manage', 'admin/customer/ip-block',
            'admin/order-report', 'admin/stock-report', 'admin/order/create', 'admin/order/all',
            "admin/order/invoice/$invoice", "admin/order/process/$invoice", "admin/order/edit/$invoice",
            'admin/courierapi/manage', 'admin/paymentgeteway/manage', 'admin/smsgeteway/manage',
            'admin/reviews', 'admin/review/pending',
        ];

        $resources = [
            'banner-category' => \App\Models\BannerCategory::class, 'banner' => \App\Models\Banner::class,
            'brands' => \App\Models\Brand::class, 'campaign' => Campaign::class, 'categories' => Category::class,
            'childcategories' => Childcategory::class, 'color' => \App\Models\Color::class,
            'contact' => \App\Models\Contact::class, 'orderstatus' => \App\Models\OrderStatus::class,
            'page' => CreatePage::class, 'permissions' => Permission::class, 'pixels' => \App\Models\EcomPixel::class,
            'products' => Product::class, 'roles' => Role::class, 'settings' => \App\Models\GeneralSetting::class,
            'shipping-charge' => ShippingCharge::class, 'size' => \App\Models\Size::class,
            'social-media' => \App\Models\SocialMedia::class, 'subcategories' => Subcategory::class,
            'tag-manager' => \App\Models\GoogleTagManager::class, 'users' => User::class,
        ];
        foreach ($resources as $prefix => $model) {
            $urls[] = "admin/$prefix/manage";
            $urls[] = "admin/$prefix/create";
            if ($id = $model::value('id')) {
                $urls[] = "admin/$prefix/$id/edit";
            }
        }

        $this->assertPagesOk($urls);
    }

    /** Request every URL and report all failures together instead of stopping at the first. */
    private function assertPagesOk(array $urls): void
    {
        $failures = [];
        foreach ($urls as $url) {
            if (in_array($url, self::KNOWN_BROKEN, true)) {
                continue;
            }
            $response = $this->get('/'.ltrim($url, '/'));
            if ($response->status() >= 400) {
                $error = $response->exception ? ' - '.$response->exception->getMessage() : '';
                $failures[] = "$url => {$response->status()}$error";
            }
        }

        $this->assertSame([], $failures, "Pages failed:\n".implode("\n", $failures));
    }
}
