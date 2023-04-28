<?php

class Custom_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'custom_widget',
            'Custom Widget',
            array('description' => 'A custom widget that communicates with chatgpt and provides a response.')
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script('custom-widget-script', plugins_url('custom-widget-script.js', __FILE__), array('jquery'), '1.0', true);
    }

    public function widget($args, $instance) {
        wp_enqueue_style('custom-widget-style', plugins_url('custom-widget-style.css', __FILE__));
        wp_enqueue_script('custom-widget-script', plugins_url('custom-widget-script.js', __FILE__), array('jquery'), '1.0', true);
        ?>
        <div class="custom-widget-container">
             <input type="text" id="custom-widget-input" placeholder="Enter your question!" />
             <button id="custom-widget-submit">Submit</button>
            <div id="custom-widget-response-container">
                <div id="custom-widget-response"></div>
            </div>
        </div>
        <?php
    }

   public function shortcode_input() {
    $this->enqueue_scripts();
    ob_start();
    ?>
    <div class="custom-widget-container">
         <input type="text" id="custom-widget-input" placeholder="Enter your Australian Tax, ASIC or Accounting related question" />
         <button id="custom-widget-submit">Submit</button>
         <div id="custom-widget-loading" class="loading hidden"></div>
    </div>
    <?php
    return ob_get_clean();
}

    
    public function shortcode_response() {
        $this->enqueue_scripts();
        ob_start();
        ?>
        <div class="custom-widget-container">
            <div id="custom-widget-response-container">
                <div id="custom-widget-response">
					<span class="placeholder-text">Answer</span>
				</div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}