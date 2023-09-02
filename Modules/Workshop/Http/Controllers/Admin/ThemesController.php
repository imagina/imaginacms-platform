<?php

namespace Modules\Workshop\Http\Controllers\Admin;

use Illuminate\View\View;
use FloatingPoint\Stylist\Theme\Theme;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Workshop\Manager\ThemeManager;

class ThemesController extends AdminBaseController
{
    /**
     * @var ThemeManager
     */
    private $themeManager;

    public function __construct(ThemeManager $themeManager)
    {
        parent::__construct();

        $this->themeManager = $themeManager;
    }

    public function index(): View
    {
        $themes = $this->themeManager->all();

        return view('workshop::admin.themes.index', compact('themes'));
    }

    public function show(Theme $theme): View
    {
        return view('workshop::admin.themes.show', compact('theme'));
    }
}
