<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Composers;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\View;

/**
 * This is the theme composer class.
 *
 * @author James Brooks <james@alt-three.com>
 * @author Graham Campbell <graham@alt-three.com>
 */
class ThemeComposer
{
    /**
     * The illuminate config instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new theme composer.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     * @return void
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->withThemeBackgroundColor($this->config->get('setting.style_background_color', '#f7fcfc'));
        $view->withThemeBackgroundFills($this->config->get('setting.style_background_fills', '#FFFFFF'));
        $view->withThemeBannerBackgroundColor($this->config->get('setting.style_banner_background_color', ''));
        $view->withThemeBannerPadding($this->config->get('setting.style_banner_padding', '40px 0'));
        $view->withThemeTextColor($this->config->get('setting.style_text_color', '#333333'));
        $view->withThemeReds($this->config->get('setting.style_reds', '#e52e2e'));
        $view->withThemeBlues($this->config->get('setting.style_blues', '#0077cc'));
        $view->withThemeGreens($this->config->get('setting.style_greens', '#009900'));
        $view->withThemeYellows($this->config->get('setting.style_yellows', '#FFBB55'));
        $view->withThemeOranges($this->config->get('setting.style_oranges', '#ff9900'));
        $view->withThemeGreys($this->config->get('setting.style_greys', '#888888'));
        $view->withThemeMetrics($this->config->get('setting.style_metrics', ' #99CCFF'));
        $view->withThemeLinks($this->config->get('setting.style_links', '#009900'));
    }
}
