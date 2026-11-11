<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;
use App\Models\GeneralSetting;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SocialMedia;
use App\Models\Contact;
use App\Models\CreatePage;
use App\Models\OrderStatus;
use App\Models\EcomPixel;
use App\Models\GoogleTagManager;
use App\Models\Order;
use App\Models\PaymentGateway;
use Config;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('payment_gateways')) {
            $shurjopay = PaymentGateway::where(['status' => 1, 'type' => 'shurjopay'])->first();
            if ($shurjopay) {
                Config::set(['shurjopay.apiCredentials.username' => $shurjopay->username]);
                Config::set(['shurjopay.apiCredentials.password' => $shurjopay->password]);
                Config::set(['shurjopay.apiCredentials.prefix' => $shurjopay->prefix]);
                Config::set(['shurjopay.apiCredentials.return_url' => $shurjopay->success_url]);
                Config::set(['shurjopay.apiCredentials.cancel_url' => $shurjopay->return_url]);
                Config::set(['shurjopay.apiCredentials.base_url' => $shurjopay->base_url]);
            }
        }

        if (Schema::hasTable('general_settings')) {
            $generalsetting = GeneralSetting::where('status', 1)->limit(1)->first();
            view()->share('generalsetting', $generalsetting);
        }

        if (Schema::hasTable('categories')) {
            $sidecategories = Category::where('parent_id', '0')->where('status', 1)->select('id', 'name', 'slug', 'status', 'image')->get();
            view()->share('sidecategories', $sidecategories);

            $menucategories = Category::where('status', 1)->select('id', 'name', 'slug', 'status', 'image')->get();
            view()->share('menucategories', $menucategories);
        }

        if (Schema::hasTable('contacts')) {
            $contact = Contact::where('status', 1)->first();
            view()->share('contact', $contact);
        }

        if (Schema::hasTable('social_media')) {
            $socialicons = SocialMedia::where('status', 1)->get();
            view()->share('socialicons', $socialicons);
        }

        if (Schema::hasTable('create_pages')) {
            $pages = CreatePage::where('status', 1)->limit(3)->get();
            view()->share('pages', $pages);

            $pagesright = CreatePage::where('status', 1)->skip(3)->limit(10)->get();
            view()->share('pagesright', $pagesright);

            $cmnmenu = CreatePage::where('status', 1)->get();
            view()->share('cmnmenu', $cmnmenu);
        }

        if (Schema::hasTable('brands')) {
            $brands = Brand::where('status', 1)->get();
            view()->share('brands', $brands);
        }

        if (Schema::hasTable('orders')) {
            $neworder = Order::where('order_status', '1')->count();
            view()->share('neworder', $neworder);

            $pendingorder = Order::where('order_status', '1')->latest()->limit(9)->get();
            view()->share('pendingorder', $pendingorder);
        }

        if (Schema::hasTable('order_statuses')) {
            $orderstatus = OrderStatus::get();
            view()->share('orderstatus', $orderstatus);
        }

        if (Schema::hasTable('ecom_pixels')) {
            $pixels = EcomPixel::where('status', 1)->get();
            view()->share('pixels', $pixels);
        }

        if (Schema::hasTable('google_tag_managers')) {
            $gtm_code = GoogleTagManager::where('status', 1)->get();
            view()->share('gtm_code', $gtm_code);
        }
    }
}
