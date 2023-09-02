<?php

namespace App\Providers;

use App\Filament\Pages\Settings;
use App\Filament\Resources\ApiResource;
use App\Filament\Resources\MailboxResource;
use App\Filament\Resources\SiteResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationBuilder;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Settings')
                    ->url(route('filament.pages.settings'))
                    ->icon('heroicon-s-cog'),
            ]);
        });

        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            return $builder
                ->groups([
                    NavigationGroup::make('Collectors')
                        ->items([
                            ...SiteResource::getNavigationItems(),
                            ...MailboxResource::getNavigationItems(),
                            ...ApiResource::getNavigationItems(),
                        ])
                        ->label('Collector resurces')
                        ->icon('heroicon-s-cog')
                        ->collapsed(),

                    NavigationGroup::make('Proccesses')
                    ->items([
                        NavigationItem::make('Overview')
                        ->icon('heroicon-o-presentation-chart-line')
                        ->activeIcon('heroicon-s-presentation-chart-line'),
                        NavigationItem::make('Proccessor One')
                        ->icon('heroicon-o-presentation-chart-line')
                        ->activeIcon('heroicon-s-presentation-chart-line'),
                        NavigationItem::make('Proccessor Two')
                        ->icon('heroicon-o-presentation-chart-line')
                        ->activeIcon('heroicon-s-presentation-chart-line'),
                        NavigationItem::make('Post Generator')
                        ->icon('heroicon-o-presentation-chart-line')
                        ->activeIcon('heroicon-s-presentation-chart-line')
                        ->group('Generators')
                        ->sort(1),
                        NavigationItem::make('Article generator')
                        ->icon('heroicon-o-presentation-chart-line')
                        ->activeIcon('heroicon-s-presentation-chart-line')
                        ->group('Generators')
                        ->sort(1),
                    ])
                    ->label('Processors')
                    ->icon('heroicon-s-cog')
                    ->collapsed(),

                    NavigationGroup::make('Deployment')
                        ->items([
                            NavigationItem::make('Overview')
                                ->icon('heroicon-o-presentation-chart-line')
                                ->activeIcon('heroicon-s-presentation-chart-line'),
                            NavigationItem::make('Game Board')
                                ->icon('heroicon-o-presentation-chart-line')
                                ->activeIcon('heroicon-s-presentation-chart-line')
                                ->group('Sites')
                                ->sort(1),
                            NavigationItem::make('Job Bord')  // Personal finances, income per moth, bills, subsripctions.Pushed from mail, added manually.
                                ->icon('heroicon-o-presentation-chart-line')
                                ->activeIcon('heroicon-s-presentation-chart-line')
                                ->group('Sites')
                                ->sort(2),
                        ])
                        ->label('Deployement Channels')
                        ->icon('heroicon-s-cog')
                        ->collapsed(),

                    NavigationGroup::make('Jobs')
                        ->items([
                            NavigationItem::make('Overview')
                            ->icon('heroicon-o-presentation-chart-line')
                            ->activeIcon('heroicon-s-presentation-chart-line'),
                        ])
                        ->label('Jobs Overviews')
                        ->icon('heroicon-s-cog')
                        ->collapsed(),

                    NavigationGroup::make('App Config')
                        ->items([
                            ...Settings::getNavigationItems(),
                        ])
                        ->label('Settings')
                        ->icon('heroicon-s-cog')
                        ->collapsed(),
                ]);
        });

    }
}
