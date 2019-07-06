<?php
namespace Jankx;

class Register
{
    private static function registerSidebar($id, $args)
    {
        $args = wp_parse_args(
            $args,
            apply_filters(
                'jankx_sidebar_args',
                array(
                    'before_widget' => '<div id="%1%s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h4 class="wtitle widget-title"><span>',
                    'after_title'   => '</span></h4>',
                )
            )
        );
        $args['id'] = $id;
        register_sidebar($args);
    }

    public static function menus()
    {
        $supportMenus = apply_filters('jankx_support_menus', array(
            'primary' => __('Primary Menu', 'jankx'),
        ));
        foreach ($supportMenus as $location => $description) {
            register_nav_menu($location, $description);
        }
    }

    public static function sidebars()
    {
        $maxSidebars = apply_filters('jankx_support_max_sidebars', 2);

        if ($maxSidebars > 0) {
            self::registerSidebar(
                'primary',
                apply_filters(
                    'jankx_sidebar_primary_args',
                    array(
                        'name' => __('Primary Sidebar', 'jankx')
                    )
                )
            );
        }
        if ($maxSidebars > 1) {
            self::registerSidebar(
                'sidebar-alt',
                apply_filters(
                    'jankx_sidebar_alt_args',
                    array(
                        'name' => __('Second Sidebar', 'jankx')
                    )
                )
            );
        }

        $additionSidebars = apply_filters('jankx_addition_sidebars', array());
        if (empty($additionSidebars)) {
            return;
        }
        foreach ($additionSidebars as $additionSidebar => $sidebarArgs) {
            self::registerSidebar(
                $additionSidebar,
                apply_filters(
                    "jankx_sidebar_{$additionSidebar}_args",
                    $sidebarArgs
                )
            );
        }
    }

    public function footerWidgets()
    {
    }
}