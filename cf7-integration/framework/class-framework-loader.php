<?php
/**
 * Framework Loader Class
 * 
 * Handles loading of framework components
 * 
 * @package    CF7_Integration
 * @subpackage CF7_Integration/framework
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Framework loader class
 */
class CF7_Framework_Loader {
    
    /**
     * The array of actions registered for the framework.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $actions    The actions registered for the framework.
     */
    protected $actions;

    /**
     * The array of filters registered for the framework.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $filters    The filters registered for the framework.
     */
    protected $filters;

    /**
     * Initialize the framework components.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->actions = array();
        $this->filters = array();
    }

    /**
     * Add a hook for an action
     *
     * @since    1.0.0
     * @param    string    $hook        The name of the action to be registered.
     * @param    object    $component   An object that exposes a callbale API.
     * @param    string    $callback    The name of the method on the $component to be called.
     * @param    int       $priority    Optional. The priority at which the method should be called. Default is 10.
     * @param    int       $accepted_args    Optional. The number of arguments that should be passed to the method. Default is 1.
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a hook for a filter
     *
     * @since    1.0.0
     * @param    string    $hook        The name of the filter to be registered.
     * @param    object    $component   An object that exposes a callable API.
     * @param    string    $callback    The name of the method on the $component to be called.
     * @param    int       $priority    Optional. The priority at which the method should be called. Default is 10.
     * @param    int       $accepted_args    Optional. The number of arguments that should be passed to the method. Default is 1.
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1) {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function to add hooks
     *
     * @since    1.0.0
     * @param    array     $hooks       The collection of hooks to be registered.
     * @param    string    $hook        The name of the WordPress filter that is being registered.
     * @param    object    $component   An object that exposes a callable API.
     * @param    string    $callback    The name of the method on the $component to be called.
     * @param    int       $priority    The priority at which the method should be called.
     * @param    int       $accepted_args    The number of arguments that should be passed to the method.
     * @return    array                                  The collection of registration actions to be registered with WordPress.
     */
    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args) {
        $hooks[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;
    }

    /**
     * Register the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        foreach ($this->actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }
    }
}