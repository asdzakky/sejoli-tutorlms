<?php
namespace SejoliTutor\Front;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ridwan-arifandi.com
 * @since      1.0.0
 *
 * @package    SejoliLP
 * @subpackage SejoliLP/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    SejoliLP
 * @subpackage SejoliLP/public
 * @author     Ridwan Arifandi <orangerdigiart@gmail.com>
 */
class Member {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * Course menu position
     * @since   1.0.0
     * @var     integer
     */
    protected $menu_position = 3;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    /**
     * Add course menu to default member-area menu
     * Hooked via filter sejoli/member-area/menu, priority 999
     * @since   1.0.0
     * @param   array   $menu   Member area men
     * @return  array   Modified member area menu with course menu
     */
    public function add_course_menu(array $menu) {

        $all_course_menu = array(
            'link'    => site_url('member-area/course-list'),
            'label'   => __('Semua Kelas','sejoli'),
            'icon'    => 'graduation cap icon',
            'class'   => 'item',
            'submenu' => []
        );

        $enrolled_course_menu  = array(
            'link'    => site_url('member-area/enrolled-course-list'),
            'label'   => __('Kelas Anda','sejoli'),
            'icon'    => 'graduation cap icon',
            'class'   => 'item',
            'submenu' => []
        );

        // Add course menu in selected position
        $menu   =   array_slice($menu, 0, $this->menu_position, true) +
                    array(
                        'tutor-all-course'      => $all_course_menu,
                        'enrolled-tutor-course' => $enrolled_course_menu
                    ) +
                    array_slice($menu, $this->menu_position, count($menu) - 1, true);

        return $menu;
    }

	/**
	 * Modify member area url
	 * Hooked via filter sejoli/member-area/menu-url, priority 1
	 * @since 	1.0.1
	 * @param  string 	$menu_url
	 * @param  WP_Post 	$menu_object
	 * @return string
	 */
	public function modify_member_area_url($menu_url, $menu_object) {

		if('sejoli-tutorlms-all-course-list' === $menu_object->object) :
			return site_url('member-area/course-list');
        elseif('sejoli-tutorlms-enrolled-course-list' === $menu_object->object) :
            return site_url('member-area/enrolled-course-list');
		endif;

		return $menu_url;
	}

    /**
     * Add course menu to menu backend area
     * Hooked via filter sejoli/member-area/backend/menu, priority 999
     * @since   1.0.0
     * @param   array   $menu   Sejoli member area menu
     * @return  array   Modified member area menu
     */
    public function add_course_menu_in_backend(array $menu) {

        $all_course_menu = array(
            'title'  => __('Semua Kelas (TutorLMS)', 'sejoli'),
            'object' => 'sejoli-tutorlms-all-course-list',
            'url'    => site_url('member-area/course-list')
        );

        $enrolled_course_menu = array(
            'title'  => __('Kelas Anda (TutorLMS)', 'sejoli'),
            'object' => 'sejoli-tutorlms-enrolled-course-list',
            'url'    => site_url('member-area/enrolled-course-list')
        );

        // Add course menu in selected position
        $menu   =   array_slice($menu, 0, $this->menu_position, true) +
                    array(
                        'tutorlms-all-courses'      => $all_course_menu,
                        'tutorlms-enrolled-courses' => $enrolled_course_menu
                    ) +
                    array_slice($menu, $this->menu_position, count($menu) - 1, true);

        return $menu;
    }

    /**
     * Set template file for learnpress template
     * Hooked via sejoli/template-file, priority 999
     * @since   1.0.0
     * @param   string  $file
     * @param   string  $view_request
     */
    public function set_template_file(string $file, string $view_request) {

        if('course-list' === $view_request) :

            return SEJOLITUTOR_DIR . 'template/all-course-list.php';

        elseif('enrolled-course-list' === $view_request) :

            return SEJOLITUTOR_DIR . 'template/enrolled-course-list.php';

        endif;

        return $file;
    }

}
