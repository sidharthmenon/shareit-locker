<?php 
    /*
    Plugin Name: shareIt.js – Social Content Locker jQuery Plugin 
    Plugin URI: https://github.com/sidharthmenon/shareit-locker
    Description: shareIt.js is a jQuery Social Content Locker Plugin. With shareIt, you can lock anything in your content and the content will be automatically unlocked when user share it on Social Media.
    Author: Sidharth Menon
    Version: 2.0
    Author URI: http://www.sidharthmenon.com   
    */

    function shareit_add_header_items()
    {
        echo '<script type="text/javascript" src="'.plugins_url("js/libs/jquery.min.js", __FILE__).'"></script>';
        echo '<script type="text/javascript" src="'.plugins_url("js/libs/jquery.ui.highlight.min.js", __FILE__).'"></script>';
        echo '<script type="text/javascript" src="'.plugins_url("js/pandalocker.2.0.0.js", __FILE__).'"></script>';
        echo '<link href="'.plugins_url("css/pandalocker.2.0.0.min.css", __FILE__).'" rel="stylesheet"/>';
        
        $disp_title = get_option('shareit_disp_title');
        $disp_text = get_option('shareit_disp_text');
        $disp_theme = get_option('shareit_disp_theme');
        $fb_appid = get_option('shareit_fb_appid');
        $g_ana = get_option('shareit_g_ana');
        
        echo <<<EEE
        <script>
jQuery(document).ready(function ($) {
   $('.to-lock').sociallocker({
	text:{
	   header: '$disp_title',
	   message: '$disp_text'
	},
	theme: '$disp_theme',
	googleAnalytics: true,
	facebook:{
	   appId: '$fb_appid'
	},
	buttons:{
	   order: ["facebook-share","google-share","twitter-tweet"],
	   counters: true,
	   lazy: false
	}
   });
});
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '$g_ana', 'auto');
  ga('send', 'pageview');

</script>
EEE;
        
    }
    
    function shareit_add_admin_menu()
    {
        add_options_page( "Shareit - Social Locker", "Shareit - Social Locker", 1, "Shareit - Social Locker", shareit_admin_page);
    }
    
    function shareit_admin_page()
    {
        if(isset($_POST['submit']))
        {
            
            $disp_title = $_POST['disp_title'];
            update_option('shareit_disp_title',$disp_title);
            
            $disp_text = $_POST['disp_text'];
            update_option('shareit_disp_text',$disp_text);
            
            $disp_theme = $_POST['disp_theme'];
            update_option('shareit_disp_theme', $disp_theme);
            
            $fb_appid = $_POST['fb_appid'];
            update_option('shareit_fb_appid', $fb_appid);
            
            $g_ana = $_POST['g_ana'];
            update_option('shareit_g_ana', $g_ana);
            
            ?>
            <div class="updated"><p><strong>Options Saved</strong></p></div>
            <?php
        }
        
            $disp_title = get_option('shareit_disp_title');
            $disp_text = get_option('shareit_disp_text');
            $disp_theme = get_option('shareit_disp_theme');
            $fb_appid = get_option('shareit_fb_appid');
            $g_ana = get_option('shareit_g_ana');
            ?>
            <div class="wrap">
                <h3>Shareit - Social Locker Settings</h3>
                <form name="shareit_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                    <h4>General Settings</h4>
                    <p>Display Title : <input type="text" name="disp_title" value="<?php echo $disp_title ?>"></p>
                    <p>Display Text : <input type="text" name="disp_text" value="<?php echo $disp_text ?>"></p>
                    <p>Display Theme :
                        <select name="disp_theme">
                            <option value="starter" <?php echo ($disp_theme=="starter")?"selected":""; ?> >Starter</option>
                            <option value="secrets" <?php echo ($disp_theme=="secrets")?"selected":""; ?> >Secret</option>
                            <option value="flat" <?php echo ($disp_theme=="flat")?"selected":""; ?> >Flat</option>
                            <option value="dandyish" <?php echo ($disp_theme=="dandyish")?"selected":""; ?> >Dandish</option>
                            <option value="glass" <?php echo ($disp_theme=="glass")?"selected":""; ?> >Glass</option>
                        </select>
                    <hr/>
                    <h4>Facebook Settings</h4>
                    <p>Facebook App Id : <input type="text" name="fb_appid" value="<?php echo $fb_appid ?>"></p>
                    <hr/>
                    <h4>Google Settings</h4>
                    <p>Google Analytics : <input type="text" name="g_ana" value="<?php echo $g_ana ?>"></p>
                    <p class="submit">
                        <input type="submit" name="submit" value="Update Options" />
                    </p>
                </form>
            </div>
            <?php
        
    }
    
    function shareit_shortcode($atts, $content= null)
    {
        $locker= '<div class="to-lock" style="display: none; text-align: center;">'.$content.'</div>';
	return $locker;
    }
    
    add_action('wp_head','shareit_add_header_items');
    add_action('admin_menu', 'shareit_add_admin_menu');
    add_shortcode('shareit_locker', shareit_shortcode);
?>