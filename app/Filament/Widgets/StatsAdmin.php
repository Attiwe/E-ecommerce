<?php

namespace App\Filament\Widgets;

use App\Models\LoginUser;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
 
class StatsAdmin extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make( 'المستخدمين' , User::query()->count())   
            ->description('عدد المسجلين  لوحه التحكم ')
                        ->chart([7, 2, 10, 3, 15, 4, 17])
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
            Stat::make('التسجيل علي الموقع', LoginUser::query()->count())   
                ->description('عدد المسجلين في الموقع ')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

                Stat::make('الطلبات التي لم يتم تسليمها الي الان', Order::query()->where('status', 1)->count())    
                ->description(' عدد الطلبات اللتي لم تتم بعد')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
                Stat::make('الطلبات اللتي تم تسليمها', Order::query()->where('status', 0)->count())   
                ->description('   الطلبات اللتي تم تسليمها')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
    
                Stat::make('منتجات  المتاحه ', Product::query()->where('status',1)->count())   
                ->description(' عدد منتجات  المتاحه علي الموقع')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
                Stat::make('منتجات الغير متاحه', Product::query()->where('status',0)->count())   
                ->description(' عدد منتجات الغير متاحه علي الموقع')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
