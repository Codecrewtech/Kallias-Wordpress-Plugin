<?php
class DZSScrollerGallery {

    public $thepath;
    public $sliders_index = 0;
    public $cats_index = 0;
    public $the_shortcode = 'scrollergallery';
    public $admin_capability = 'manage_options';
    public $dbitemsname = 'dzssg_items';
    public $dboptionsname = 'dzssg_options';
    public $dbs = array();
    public $dbdbsname = 'dzssg_dbs';
    public $currDb = '';
    public $currSlider = '';
    public $mainitems;
    public $mainoptions;
    public $pluginmode = "plugin";
    public $alwaysembed = "on";
    public $httpprotocol = 'https';
    public $adminpagename = 'dzssg_menu';
    public $adminpagename_mo = 'dzssg-mo';
    private $usecaching = true;

    function __construct() {
        if ($this->pluginmode == 'theme') {
            $this->thepath = THEME_URL . 'plugins/dzs-scrollergallery/';
        } else {
            $this->thepath = plugins_url('', __FILE__) . '/';
        }
        
        //clear database
        //update_option($this->dbdbsname, '');

        
        $currDb = '';
        if (isset($_GET['dbname'])) {
            $this->currDb = $_GET['dbname'];
            $currDb = $_GET['dbname'];
        }
        
        
        if (isset($_GET['currslider'])) {
            $this->currSlider = $_GET['currslider'];
        }else{
            $this->currSlider = 0;
        }
        
        $this->dbs = get_option($this->dbdbsname);
        //$this->dbs = '';
        if ($this->dbs == '') {
            $this->dbs = array('main');
            update_option($this->dbdbsname, $this->dbs);
        }
        if(is_array($this->dbs) && !in_array($currDb, $this->dbs) && $currDb!='main' && $currDb!=''){
            array_push($this->dbs, $currDb);
            update_option($this->dbdbsname, $this->dbs);
        }
        //echo 'ceva'; print_r($this->dbs);
        if($currDb!='main' && $currDb!=''){
            $this->dbitemsname.='-'.$currDb;
        }

        $this->mainitems = get_option($this->dbitemsname);
        //echo 'ceva'; echo $this->mainitems;
        if ($this->mainitems == '' || (is_array($this->mainitems) && count($this->mainitems)==0)) {
            //echo 'ceva';
            //===if mainitems not set lets set some dummy
            $aux = 'a:2:{i:0;a:15:{s:8:"settings";a:16:{s:8:"feedfrom";s:6:"normal";s:2:"id";s:11:"normalitems";s:5:"width";s:4:"100%";s:6:"height";s:3:"300";s:10:"innerwidth";s:4:"1575";s:9:"itemwidth";s:3:"225";s:10:"itemheight";s:3:"150";s:4:"type";s:8:"scroller";s:19:"scrollergalleryskin";s:8:"progress";s:15:"lightboxlibrary";s:7:"zoombox";s:2:"bg";s:0:"";s:9:"bgpadding";s:2:"20";s:8:"parallax";s:3:"off";s:10:"itemmargin";s:3:"off";s:17:"recentpoststoshow";s:2:"12";s:22:"recentpostswpqueryargs";s:0:"";}i:0;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:1;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:8:"lightbox";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:39:"test <span class="fake-link">hmm</span>";s:9:"ppgallery";s:2:"t1";s:8:"desctype";s:4:"none";}i:2;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:8:"lightbox";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:2:"t1";s:8:"desctype";s:4:"none";}i:3;a:8:{s:6:"source";s:93:"https://lh4.googleusercontent.com/-eqd_2laXEus/TS6ZyTd4fEI/AAAAAAAAABA/zbWXbx_aZ7E/s300/2.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:4;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:5;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:6;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:7;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:8;a:8:{s:6:"source";s:93:"https://lh4.googleusercontent.com/-eqd_2laXEus/TS6ZyTd4fEI/AAAAAAAAABA/zbWXbx_aZ7E/s300/2.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:9;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:10;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:11;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:12;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}i:13;a:8:{s:6:"source";s:93:"https://lh5.googleusercontent.com/-t5k_fe6XX3s/TS6Zx44LpdI/AAAAAAAAAA8/pr3mrzoZ4Bk/s200/1.jpg";s:8:"thethumb";s:92:"http://localhost/wordpress/wp-content/plugins/dzs-scrollergallery/admin/img/defaultthumb.png";s:4:"type";s:10:"just image";s:12:"theitemwidth";s:0:"";s:13:"theitemheight";s:0:"";s:11:"description";s:0:"";s:9:"ppgallery";s:0:"";s:8:"desctype";s:4:"none";}}i:1;a:1:{s:8:"settings";a:15:{s:8:"feedfrom";s:12:"recent-posts";s:2:"id";s:11:"recentitems";s:5:"width";s:4:"100%";s:6:"height";s:3:"300";s:10:"innerwidth";s:4:"1575";s:9:"itemwidth";s:3:"225";s:10:"itemheight";s:3:"150";s:4:"type";s:8:"scroller";s:19:"scrollergalleryskin";s:6:"normal";s:2:"bg";s:0:"";s:9:"bgpadding";s:2:"20";s:8:"parallax";s:3:"off";s:10:"itemmargin";s:3:"off";s:17:"recentpoststoshow";s:2:"12";s:22:"recentpostswpqueryargs";s:0:"";}}}';
            $this->mainitems = unserialize($aux);
            //echo 'cevaa'; print_r($this->mainitems); echo $this->dbitemsname;
            update_option($this->dbitemsname, $this->mainitems);
        }
        
        
        //===default options
        $defaultOpts = array(
                'usewordpressuploader' => 'on',
                'embed_prettyphoto' => 'on',
                'embed_masonry' => 'on',
                'is_safebinding' => 'on',
            'admin_close_otheritems' => 'on',
            );
        $this->mainoptions = get_option($this->dboptionsname);
        if ($this->mainoptions == '') {
            $this->mainoptions = $defaultOpts;
            update_option($this->dboptionsname, $this->mainoptions);
        }
        
        $this->mainoptions = array_merge($defaultOpts, $this->mainoptions);
        //print_r($this->mainoptions);
        load_plugin_textdomain('dzssg', false, basename(dirname(__FILE__)) . '/languages');

        $this->post_options();

        //echo $newurl;

        
        $uploadbtnstring = '<button class="button-secondary action upload_file ">Upload</button>';



        if ($this->mainoptions['usewordpressuploader'] != 'on') {
            $uploadbtnstring = '<div class="dzs-upload">
<form name="upload" action="#" method="POST" enctype="multipart/form-data">
    	<input type="button" value="Upload" class="btn_upl"/>
        <input type="file" name="file_field" class="file_field"/>
        <input type="submit" class="btn_submit"/>
</form>
</div>
<div class="feedback"></div>';
        }


        ///==== important: settings must have the class mainsetting
        $this->sliderstructure = '<div class="slider-con" style="display:none;">
        <div class="setting type_all">
            <div class="setting-label">'.__('Select Feed Mode', 'dzsvg').'</div>
                <div class="main-feed-chooser select-hidden-metastyle">
                <select class="textinput mainsetting" name="0-settings-feedfrom">
                    <option value="normal">'.__('Normal', 'dzsvg').'</option>
                    <option value="recent-posts">'.__('Recent Posts', 'dzsvg').'</option>
                </select>
                <div class="option-con clearfix">
                    <div class="an-option">
                    <div class="an-title">
                    '.__('Normal', 'dzsvg').'
                    </div>
                    <div class="an-desc">
                    '.__('Feed from custom items you set below.', 'dzsvg').'
                    
                    </div>
                    </div>
                    
                    <div class="an-option">
                    <div class="an-title">
                    '.__('Recent Posts', 'dzsvg').'
                    </div>
                    <div class="an-desc">
                    '.__(' Feed from a specific number of recents posts you set below.', 'dzsvg').'
                   
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="settings-con">
        <h4>'.__('General Options', 'dzssg').'</h4>
        <div class="setting type_all">
            <div class="setting-label">'.__('ID', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting main-id" name="0-settings-id" value="default"/>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Width', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting" name="0-settings-width" value="100%"/>
                <div class="sidenote">'.__('Leave <strong>100%</strong> here for responsive mode.', 'dzssg').'</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Height', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting" name="0-settings-height" value="300"/>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Inner Width', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting" name="0-settings-innerwidth" value="1575"/>
                <div class="sidenote">'.__('Number of space per row. Increase to allow more items per row.', 'dzssg').'</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Item Width', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting" name="0-settings-itemwidth" value="225"/>
                <div class="sidenote">'.__('Leave blank for auto size...', 'dzssg').'</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Item Height', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting" name="0-settings-itemheight" value="150"/>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Type', 'dzssg').'
                <div class="info-con">
                <div class="info-icon"></div>
                <div class="sidenote">'.__('Select arrows for the infinite gallery and scroller for the scrollbar gallery.', 'dzssg').'</div>
            </div></div>
            <select class="textinput mainsetting styleme" name="0-settings-type">
            <option>scroller</option>
            <option>arrows</option>
            <option>justmasonry</option>
            </select>
        </div>
        <div class="setting styleme">
            <div class="setting-label">'.__('Scroller Skin', 'dzssg').'</div>
            <select class="textinput mainsetting styleme" name="0-settings-scrollergalleryskin">
                <option>normal</option>
                <option>facebook</option>
                <option>progress</option>
                <option>slider</option>
                <option>alternate</option>
            </select>
        </div>
        <div class="setting styleme">
            <div class="setting-label">'.__('Lightbox Library', 'dzssg').'</div>
            <select class="textinput mainsetting styleme" name="0-settings-lightboxlibrary">
                <option>zoombox</option>
                <option>prettyPhoto</option>
            </select>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Background', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting" name="0-settings-bg" value=""/>'.$uploadbtnstring.'
            <div class="sidenote">'.__('Specify a Background Image.', 'dzssg').'</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">'.__('Background Padding', 'dzssg').'</div>
            <input type="text" class="textinput mainsetting" name="0-settings-bgpadding" value="20"/>
        </div>
        <div class="setting styleme">
            <div class="setting-label">'.__('Parallax', 'dzssg').'</div>
            <select class="textinput mainsetting styleme" name="0-settings-parallax">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">'.__('Enable Parallax Effect on the <strong>Background</strong>.', 'dzssg').'</div>
        </div>
        
        <div class="setting type_all">
            <div class="setting-label">' . __('Randomize / Shuffle Elements', 'dzsvg') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-randomize">
                <option value="off">' . __('off', 'dzsvg') . '</option>
                <option value="on">' . __('on', 'dzsvg') . '</option>
            </select>
        </div>
        
        <div class="setting styleme">
            <div class="setting-label">'.__('Item Margin', 'dzssg').'</div>
            <select class="textinput mainsetting styleme" name="0-settings-itemmargin">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">'.__('Enable a 10px margin between items.', 'dzssg').'</div>
        </div>

        </div><!--end settings con-->
        <div class="modes-con">
        <div class="setting type_all mode_recent-posts">
            <div class="setting_label">' . __('How many recent posts to show ?', 'dzsvg') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-recentpoststoshow" value="12"/>
        </div>
        <div class="setting type_all mode_recent-posts">
            <div class="setting_label">' . __('Other WP Query Args ?', 'dzsvg') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-recentpostswpqueryargs" value=""/>
            <div class="sidenote">'.__('Advanced funtionality. Modify only if you need some extra parameters.', 'dzssg').'</div>
        </div>
        
</div>
        
        <div class="master-items-con mode_normal">
        <div class="items-con"></div>
        <a href="#" class="add-item"></a>
        </div><!--end master-items-con-->
        <div class="clear"></div>
        </div>';
        $this->itemstructure = '<div class="item-con">
            <div class="item-delete">x</div>
            <div class="item-duplicate"></div>
        <div class="item-preview" style="">
        </div>
        <div class="item-settings-con">
        <div class="setting">
            <div class="setting-label">'.__('Source', 'dzssg').'
                <div class="info-con">
                <div class="info-icon"></div>
                <div class="sidenote">Below you will enter your video address. If it is a video from YouTube or Vimeo you just need to enter the id of the video in the "Video:" field. The ID is the bolded part http://www.youtube.com/watch?v=<strong>j_w4Bi0sq_w</strong>. If it is a local video you just need to write its location there or upload it through the Upload button ( .mp4 / .flv format ).</div>
                </div>
            </div>
<textarea class="textinput main-source main-thumb  type_all" name="0-0-source" style="width:160px; height:23px;">'.$this->thepath.'admin/img/defaultthumb.png</textarea>'.$uploadbtnstring.'
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Link / Big Image', 'dzssg').'</div>
            <input class="textinput upload-prev" name="0-0-thethumb" style="width:160px; height:23px;" value="'.$this->thepath.'admin/img/defaultthumb.png"/>' . $uploadbtnstring . '
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Type', 'dzssg').':</div>
            <select class="textinput item-type styleme type_all" name="0-0-type">
            <option>just image</option>
            <option>lightbox</option>
            <option>inline</option>
            </select>
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Link Whole Container', 'dzssg').':</div>
            <select class="textinput item-type styleme type_all" name="0-0-link_wholecontainer">
            <option>off</option>
            <option>on</option>
            </select>
            <div class="sidenote">'.__('Make the whole container link / lightbox - even though the description would be over.', 'dzssg').'</div>
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Item Width', 'dzssg').'</div>
            <input class="textinput" type="text" name="0-0-theitemwidth"/>
            <div class="sidenote">'.__('You can force an item width if you wish to.', 'dzssg').'</div>
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Item Height', 'dzssg').'</div>
            <input class="textinput" type="text" name="0-0-theitemheight"/>
            <div class="sidenote">'.__('You can force an item height if you wish to.', 'dzssg').'</div>
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Description', 'dzssg').':</div>
            <textarea class="textinput" name="0-0-description"></textarea>
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Lightbox Gallery', 'dzssg').'</div>
            <input class="textinput upload-prev" type="text" name="0-0-ppgallery"/>
        </div>
        <div class="setting">
            <div class="setting-label">'.__('Description Type', 'dzssg').':</div>
                <div class="sidenote">A descriptive small icon appearing in the top right symbolizing what the link is</div>
            <select class="textinput item-type styleme type_all" name="0-0-desctype">
            <option>none</option>
            <option>image</option>
            <option>video</option>
            <option>link</option>
            </select>
        </div>
        </div><!--end item-settings-con-->
        </div>';
        
        
        if(isset($_GET['deleteslider'])){
            //print_r($this->mainitems);
            unset($this->mainitems[$_GET['deleteslider']]);
            $this->mainitems = array_values($this->mainitems);
            $this->currSlider = 0;
            //print_r($this->mainitems);
            update_option($this->dbitemsname, $this->mainitems);
        }
        //print_r($this->mainitems);
        


        add_shortcode($this->the_shortcode, array($this, 'show_shortcode'));
        add_shortcode('dzs_' . $this->the_shortcode, array($this, 'show_shortcode'));


        add_shortcode('vimeo', array($this, 'vimeo_func'));
        add_shortcode('youtube', array($this, 'youtube_func'));
        add_shortcode('video', array($this, 'video_func'));

        add_action('init', array($this, 'handle_init'));
        add_action( 'add_meta_boxes', array($this, 'handle_add_meta_boxes') );
        add_action('wp_ajax_dzssg_ajax', array($this, 'post_save'));
        
        add_action('save_post', array($this, 'admin_meta_save'));
        
        add_action('wp_ajax_dzssg_ajax_mo', array($this, 'post_save_mo'));

        add_action('admin_menu', array($this, 'handle_admin_menu'));
        add_action('admin_head', array($this, 'handle_admin_head'));
        
        
        add_action('wp_footer', array($this, 'handle_footer'));

        if ($this->pluginmode == 'theme') {
        }
        if ($this->pluginmode != 'theme') {
        }
    }
    function handle_admin_head() {
        //echo 'ceva23';
        //siteurl : "'.site_url().'", 
        //$params = array( 'addslider' => '_currslider_' );
        $aux = remove_query_arg( 'addslider', dzs_curr_url() );
        $aux = remove_query_arg( 'deleteslider', $aux );
        $params = array( 'currslider' => '_currslider_' );
        $newurl = add_query_arg( $params, $aux );
        $params = array( 'deleteslider' => '_currslider_' );
        $delurl = add_query_arg( $params, $aux );
        echo '<script>var dzssg_settings = { thepath: "' . $this->thepath . '", is_safebinding: "'.$this->mainoptions['is_safebinding'].'", admin_close_otheritems:"'.$this->mainoptions['admin_close_otheritems'].'" ';
        
        if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename && $this->mainitems[$this->currSlider] == '') {
            echo ', addslider:"on"';
        }
        echo ', urldelslider:"'.$delurl.'", urlcurrslider:"'.$newurl.'", currSlider:"'.$this->currSlider.'", currdb:"'.$this->currDb.'"}; </script>';
    }
    function handle_footer(){
    }

    function log_event($arg) {
        $fil = dirname(__FILE__) . "/log.txt";
        $fh = fopen($fil, 'a') or die("cannot open file");
        fwrite($fh, ($arg . "\n"));
        fclose($fh);
    }
    
    function show_shortcode($atts){
        global $post;
        $fout = '';

        $margs = array(
            'id' => 'default'
            ,'db' => ''
            ,'category' => ''
            ,'fullscreen' => 'off'
        );
        
        if($atts==''){
            $atts=array();
        }
        $margs = array_merge($margs, $atts);
        
        
        //===setting up the db
        $currDb = '';
        if (isset($margs['db']) && $margs['db']!='') {
            $this->currDb = $margs['db'];
            $currDb = $this->currDb;
        }
        $this->dbs = get_option($this->dbdbsname);
        
        //echo 'ceva'; print_r($this->dbs);
        if($currDb!='main' && $currDb!=''){
            $this->dbitemsname.='-'.$currDb;
            $this->mainitems = get_option($this->dbitemsname);
        }
        //===setting up the db END
        
        
        
        
        if ($this->mainitems == ''){
            return;
        }

        $this->front_scripts();
        
        

        $this->sliders_index++;


        $i = 0;
        $k = 0;
        $id = 'default';
        if (isset($margs['id'])) {
            $id = $margs['id'];
        }
        
        //echo 'ceva' . $id;
        for ($i = 0; $i < count($this->mainitems); $i++) {
            if ((isset($id)) && ($id == $this->mainitems[$i]['settings']['id']))
                $k = $i;
        }

        $its = $this->mainitems[$k];
        
        
        if ($its['settings']['randomize'] == 'on' && is_array($its)) {

            $backup_its = $its;
//print_r($its); $rand_keys = array_rand($its, count($its)); print_r($rand_keys);
            shuffle($its);
//print_r($its);print_r($backup_its);

            for ($i = 0; $i < count($its); $i++) {
                if (isset($its[$i]['feedfrom'])) {
                    //print_r($it);

                    unset($its[$i]);
                }
            }
            $its['settings'] = $backup_its['settings'];
            $its = array_reverse($its);
//print_r($its);
        }
        
        
        if($its['settings']['feedfrom']=='recent-posts'){
            foreach($its as $lab => $val){
                //print_r($its[$lab]); echo $lab;
                if($lab!='settings'){
                    unset($its[$lab]);
                }
            }
            
            ///==hmm eliminate teh remains
            if(isset($its[0])){
                unset($its[0]);
            }
            $args = array(
                'posts_per_page' => $its['settings']['recentpoststoshow'],
            );
            $p2args = array();
            parse_str($its['settings']['recentpostswpqueryargs'], $p2args);
            
            $args = array_merge($args, $p2args);
            
            $wpquery = new WP_Query($args);
            
            //print_r($wpquery);
            $i = 0;
            foreach($wpquery->posts as $po){
                //print_r($po);
                
                $the_id = $po->ID;
                
            $the_src = wp_get_attachment_image_src(get_post_thumbnail_id( $the_id ), 'full');
            //print_r($the_src);
            $the_thumb_src = $the_src[0];
                
                $argspo = array(
                    'item_type' => 'post',
                    'type' => 'just image',
                    'source' => ''.$this->thepath.'admin/img/defaultthumb.png',
                    'thethumb' => get_permalink($the_id),
                    'theitemwidth' => '',
                    'theitemheight' => '',
                    'description' => '',
                );
                
                $argsreal = array();
                
                if(get_post_meta($the_id, 'dzssg_item_type', true)!=''){
                $argsreal['type']=get_post_meta($the_id, 'dzssg_item_type', true);
                }
                $argsreal['source']=$the_thumb_src;
                $argsreal['theitemwidth']=get_post_meta($the_id, 'dzssg_force_width', true);
                $argsreal['theitemheight']=get_post_meta($the_id, 'dzssg_force_height', true);
                $argsreal['description']='';
                if(get_post_meta($the_id, 'dzssg_disable_title', true)!='on'){
                    if(get_post_meta($the_id, 'dzssg_link_title', true)=='item'){
                        $argsreal['description'].='<a href="'.get_permalink($the_id).'">';
                    }
                    if(get_post_meta($the_id, 'dzssg_link_title', true)=='customlink'){
                        $argsreal['description'].='<a href="'.get_post_meta($the_id, 'dzssg_customlink', true).'">';
                        //dzssg_customlink
                    }
                    $argsreal['description'].='<h5>'.$po->post_title.'</h5>';
                    if(get_post_meta($the_id, 'dzssg_link_title', true)=='item' || get_post_meta($the_id, 'dzssg_link_title', true)=='customlink'){
                        $argsreal['description'].='</a>';
                    }
                }
                
                
                $readmore = 'off';
                if($argsreal['type']!='' && $argsreal['type']!='just image'){
                    $readmore = 'on';
                }
                if(get_post_meta($the_id, 'dzssg_disable_description', true)!='on'){
                    $argsreal['description'].=dzs_get_excerpt($the_id, array('forceexcerpt'=>false, 'striptags' => true, 'readmore' => $readmore, 'readmore_markup' => '<br><br><span class="fake-link">'.__('Read More', 'dzssg').'</span>'));
                }
                
                
                $argsreal = array_merge($argspo, $argsreal);
                
                $its[$i] = $argsreal;
                
                ++$i;
            }
        }
        
        
        
        //print_r($its);
        
        //print_r($this->mainitems);
        $w = $its['settings']['width'] . 'px';
        $h = $its['settings']['height'] . 'px';
        $fullscreenclass = '';
        $theclass = 'scrollergallery';


        //$fout.='<div class="scrollergallery-con" style="width:'.$w.'; height:'.$h.'; opacity:0;">';


        $user_feed = '';
        $yt_playlist_feed = '';


        $skin = 'skin_default';
        //print_r($its);
        if ($its['settings']['scrollergalleryskin'] == 'facebook') {
            $skin = "skin_apple";
        }
        if ($its['settings']['scrollergalleryskin'] == 'alternate') {
            $skin = "skin_alternate";
        }
        if ($its['settings']['scrollergalleryskin'] == 'progress') {
            $skin = 'skin_progress';
        }
        if ($its['settings']['scrollergalleryskin'] == 'slider') {
            $skin = 'skin_slider';
        }
        //$fout.='ceva';


        $str_w = '';
        
        if($its['settings']['width']!=''){
            if(strpos($its['settings']['width'], '%')===false){
                $str_w = ' width:'.$its['settings']['width'].'px;';
            }else{
                $str_w = ' width:'.$its['settings']['width'].';';
            }
        }
        
        //echo DZSHelpers::hmm();
        
        //echo $str_w;
        
        $str_h = '';
        
        if($its['settings']['height']!=''){
            if(strpos($its['settings']['height'], '%')===false){
                $str_h = ' height:'.$its['settings']['height'].'px;';
            }else{
                $str_h = ' height:'.$its['settings']['height'].';';
            }
        }


        $fout.='
<div class="scroller-gallery-con" style="'.$str_w.$str_h.'">
<div class="preloader"></div>';
        
        $fout.='<div id="scrollg' . $this->sliders_index . '" class="scroller-con scroller-gallery';
        
        if($its['settings']['itemmargin']=='on'){
            $fout.=' itemmargin10';
        }
        
        $fout.='" style="'.$str_w.$str_h.' opacity:0;">';
        
        if($its['settings']['bg']!=''){
            $fout.='<div class="clip-bg">
<div class="the-bg" style="background-image: url('.$its['settings']['bg'].')"></div>
</div>';
        }
        $fout.='<div class="inner" style="width:'.$its['settings']['innerwidth'].'px">';
//print_r($its);
        
        $pitems = $its;
        unset($pitems['settings']);
        
        //print_r($its);print_r($pitems);
        
        //======= parse items ====
        $fout.= $this->parse_items($pitems, $its);
        //=======

        $fout.='</div>';
        $fout.='</div>';
        $fout.='</div>';
        $jreadycall = 'jQuery(document).ready(function($)';

$fout.='<script>
' . $jreadycall . '{
scrollerSettings = {
    settings_replacewheelxwithy:"on"
    ,settings_skin : "'.$skin.'"
    ,settings_refresh:10000
    ,settings_forcesameheight:"on"
    ,settings_multiplier:7
}
window.dzssg_init("#scrollg' . $this->sliders_index . '",{
    scrollerSettings : scrollerSettings
    ,type : "'.$its['settings']['type'].'"
    ,settings_autoCenterOnBiggerSizes:"on"
    ,design_parallaxeffect: "'.$its['settings']['parallax'].'"
    ,design_itemwidth:"'.$its['settings']['itemwidth'].'"
    ,design_itemheight:"'.$its['settings']['itemheight'].'"
    ,design_bgpadding: "'.$its['settings']['bgpadding'].'"';

//print_r($its);
    if(isset($its['settings']['lightboxlibrary'])){
        $fout.=',settings_lightboxlibrary: "'.$its['settings']['lightboxlibrary'].'"';
    };
    
    $fout.='});
});
</script>';

            if($its['settings']['lightboxlibrary']=='prettyPhoto'){
                
                wp_enqueue_script('jquery.prettyphoto', $this->thepath . "prettyphoto/jquery.prettyPhoto.js");
                wp_enqueue_style('jquery.prettyphoto', $this->thepath . 'prettyphoto/prettyPhoto.css');
            }



        return $fout;
    }
    function parse_items($pitems, $its){
        $mitems = $pitems;
        //$margs = $pargs;
        
        $fout = '';
        
        //print_r($mitems); echo count($mitems);
        for ($i = 0; $i < count($mitems); $i++) {
            $it = $mitems[$i];
            if($it['type'] == 'inline'){

            }else{

            $fout.='<div class="sgitem-tobe';

            if($it['desctype']!='none'){
                if($it['desctype']=='image'){
                    $fout.=' a-image';
                }
                if($it['desctype']=='video'){
                    $fout.=' a-video';
                }
            }
            $fout.='"';

            if($it['type']=='lightbox'){
                $fout.=' data-type="imageandlightbox"';
            }
            if($it['type']=='just image'){
                $fout.=' data-type="image"';
            }
            if($it['type']=='link'){
                $fout.=' data-type="image"';
            }
            
            
            
            if(isset($it['link_wholecontainer']) && $it['link_wholecontainer']=='on'){
                $fout.=' data-link_wholecontainer="on"';
            }
            
            $fout.=' data-src="'.$it['source'].'"';
            $fout.=' data-link="'.$it['thethumb'].'"';
            
            if($it['ppgallery']!=''){
                $fout.=' data-lightboxgallery="'.$it['ppgallery'].'"';
            }
            
            $auxp = 'theitemwidth';
            if(isset($it[$auxp]) && $it[$auxp]!=''){
                $fout.=' data-itemwidth="'.$it[$auxp].'"';
            }
            $auxp = 'theitemheight';
            if(isset($it[$auxp]) && $it[$auxp]!=''){
                $fout.=' data-itemheight="'.$it[$auxp].'"';
            }
            
            $fout.='>';
            if($it['description']!=''){
                $fout.='<div class="desc">' . $it['description'];

                if($it['desctype']=='video'){
                    $fout.='<div class="icon video"></div>';
                }

                $fout.= '</div>';
            }
            $fout.='</div>';

            }
        }
        
        return $fout;
        
    }
    function admin_init() {
        
    }
    function handle_add_meta_boxes(){
        
        add_meta_box('dzssg_meta_options', __('DZS Scroller Gallery Settings'), array($this,'admin_meta_options'), 'post', 'normal', 'high');
    }
    function admin_meta_options(){
          global $post;
          //type, item width, item height
          ?>
        <div class="dzssg-meta-bigcon">
            <?php 
    echo '<div class="dzs-setting">
            <h4 class="setting-label">'.__('Select Type', 'dzssg').'</h4>';
    //print_r()
    echo $this->misc_generate_select('dzssg_item_type', get_post_meta($post->ID, 'dzssg_item_type', true), array(
        array(
            'value' => 'just image',
            'label' => __('just image', 'dzssg'),
        ),/*
        array(
            'value' => 'lightbox',
            'label' => __('lightbox', 'dzssg'),
        ),*/
        array(
            'value' => 'link',
            'label' => __('link', 'dzssg'),
        ),
        ), array('class' => 'textinput mainsetting styleme', 'def_value' => '') ); 
    
    
            echo '</div>';
    ?>
<div class="dzs-setting"> 
    <h4><?php echo __('Force Item Width', 'dzssg'); ?></h4>
    <?php echo $this->misc_input_text('dzssg_force_width', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzssg_force_width', true)) ); ?>
    <div class='sidenote'><?php echo __('force a specific width for this item', 'dzssg'); ?></div>
</div>
<div class="dzs-setting"> 
    <h4><?php echo __('Force Item Height', 'dzssg'); ?></h4>
    <?php echo $this->misc_input_text('dzssg_force_height', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzssg_force_height', true)) ); ?>
    <div class='sidenote'><?php echo __('force a specific height for this item', 'dzssg'); ?></div>
</div>
            
            <div class="dzs-setting"> 
                <h4><?php echo __('Disable Title','dzssg'); ?></h4>
                <?php
                $lab = 'dzssg_disable_title';
                echo $this->misc_generate_select($lab,get_post_meta($post->ID,$lab,true),array(
                    array(
                        'value' => 'off',
                        'label' => __('Off','dzssg'),
                    ),
                    array(
                        'value' => 'on',
                        'label' => __('On','dzssg'),
                    ),
                ),array('class' => 'styleme','def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('Choose where clicking the item area should go. Default - no link on title. You can input the custom link below.','dzssg'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Disable Description','dzssg'); ?></h4>
                <?php
                $lab = 'dzssg_disable_description';
                echo $this->misc_generate_select($lab,get_post_meta($post->ID,$lab,true),array(
                    array(
                        'value' => 'off',
                        'label' => __('Off','dzssg'),
                    ),
                    array(
                        'value' => 'on',
                        'label' => __('On','dzssg'),
                    ),
                ),array('class' => 'styleme','def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('Choose where clicking the item area should go. Default - no link on title. You can input the custom link below.','dzssg'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Title Links To....','dzssg'); ?></h4>
                <?php
                $lab = 'dzssg_link_title';
                echo $this->misc_generate_select($lab,get_post_meta($post->ID,$lab,true),array(
                    array(
                        'value' => 'none',
                        'label' => __('Nowhere','dzssg'),
                    ),
                    array(
                        'value' => 'item',
                        'label' => __('Item URL','dzssg'),
                    ),
                    array(
                        'value' => 'customlink',
                        'label' => __('Custom Link','dzssg'),
                    ),
                        ),array('class' => 'styleme','def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('Choose where clicking the item area should go. Default - no link on title. You can input the custom link below.','dzssg'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Custom Link','dzssg'); ?></h4>
                <?php
                $lab = 'dzssg_customlink';
                echo $this->misc_input_text($lab,array('class' => '','def_value' => '','seekval' => get_post_meta($post->ID,$lab,true)));
                ?>
            </div>
        </div>
          <?php
    }
    function misc_generate_select($argname, $argval, $argopts = array(), $otherargs = array()){
        $fout = '';
        $fout.='<select';
        $fout.=' name="'.$argname.'"';
        
        if(isset($otherargs['class'])){
            $fout.=' class="'.$otherargs['class'].'"';
            
        }
        $fout.='>';
        //print_r($argopts);
        if(isset($otherargs['generatedcontent']) && $otherargs['generatedcontent']!=''){
            $fout.=$otherargs['generatedcontent'];
        }else{
            foreach ($argopts as $argopt){
                $the_label = '';
                $the_val = '';
                $str_selected = '';
                if(is_array($argopt)){
                    $the_val = $argopt['value'];
                    $the_label = $argopt['label'];
                }else{
                    $the_val = $argopt;
                    $the_label = $argopt;
                }
                if($the_val==$argval){
                    $str_selected = ' selected="selected"';
                }

                $fout.='<option value="'.$the_val.'"'.$str_selected.'>'.$the_label.'</option>';
            }
        }
        $fout.='</select>';
        return $fout;
    }
    function admin_meta_save($post_id){
        global $post;
        if(!$post){
            return;
        }
        if(isset($post->post_type) && !($post->post_type=='post' || $post->post_type=='page')){
                return $post_id;
        }
	/* Check autosave */
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
        if(isset($_REQUEST['dzs_nonce'])){
        $nonce=$_REQUEST['dzs_nonce'];
        if (! wp_verify_nonce($nonce, 'dzs_nonce') ) wp_die('Security check'); 
        }
        
        if(is_array($_POST)){
            $auxa = $_POST;
            foreach ($auxa as $label => $value){
                
            //print_r($label); print_r($value); 
                if(strpos($label, 'dzssg_')!==false){
                    DZSHelpers::wp_savemeta($post->ID, $label, $value);
                }
            }
        }
    }

    function handle_init() {
        //wp_deregister_script('jquery');        wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"), false, '1.9.0');
        wp_enqueue_script('jquery');
        if (is_admin()) {
        wp_enqueue_style('dzssg_admin_global', $this->thepath . 'admin/admin_global.css');
        wp_enqueue_script('dzssg_admin_global', $this->thepath . 'admin/admin_global.js');
            
            
            if (isset($_GET['page']) && ($_GET['page'] == $this->adminpagename)) {
                wp_enqueue_media();
                $this->admin_scripts();
            }
            
            
            if (isset($_GET['page']) && $_GET['page'] == 'dzssg-mo') {
                wp_enqueue_style('dzssg_admin', $this->thepath . 'admin/admin.css');
                wp_enqueue_script('dzssg_admin', $this->thepath . "admin/admin.js");
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_style('iphone.checkbox', $this->thepath . 'admin/checkbox/checkbox.css');
                wp_enqueue_script('iphone.checkbox', $this->thepath . "admin/checkbox/checkbox.dev.js");
            }

            if (current_user_can('edit_posts') || current_user_can('edit_pages')) {
                
                wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');
                wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');
                wp_enqueue_script('dzssg_htmleditor', $this->thepath . 'tinymce/plugin-htmleditor.js');
                wp_enqueue_script('configreceiver', $this->thepath . 'tinymce/receiver.js');
                
            }
        } else {
            if(isset($this->mainoptions['always_embed']) && $this->mainoptions['always_embed']=='on'){
                $this->front_scripts();
            }
        }
    }

    function handle_admin_menu() {

        if ($this->pluginmode == 'theme') {
            $dzssg_page = add_theme_page(__('DZS Scroller Gallery', 'dzssg'), __('DZS Scroller Gallery', 'dzssg'), $this->admin_capability, $this->adminpagename, array($this, 'admin_page'));
        } else {
            //$dzssg_page = add_options_page(__('DZS Scroller Gallery', 'dzssg'), __('DZS Scroller Gallery', 'dzssg'), $this->admin_capability, $this->adminpagename, array($this, 'admin_page'));
        
            $dzssg_page = add_menu_page(__('Scroller Gallery', 'dzssg'), __('Scroller Gallery', 'dzssg'), $this->admin_capability, $this->adminpagename, array($this, 'admin_page'), 'div');
            $dzssg_subpage = add_submenu_page($this->adminpagename, __('Scroller Gallery Settings', 'dzssg'), __('Settings', 'dzssg'), $this->admin_capability, $this->adminpagename_mo, array($this, 'admin_page_mainoptions'));
        
        }
        //echo $dzssg_page;
    }

    function admin_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('tiny_mce');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_script('dzssg_admin', $this->thepath . "admin/admin.js");
        wp_enqueue_style('dzssg_admin', $this->thepath . 'admin/admin.css');
        wp_enqueue_script('dzs.farbtastic', $this->thepath . "admin/colorpicker/farbtastic.js");
        wp_enqueue_style('dzs.farbtastic', $this->thepath . 'admin/colorpicker/farbtastic.css');
        wp_enqueue_style('dzssgdzsuploader', $this->thepath . 'admin/dzsuploader/upload.css');
        wp_enqueue_script('dzssgdzsuploader', $this->thepath . 'admin/dzsuploader/upload.js');
        wp_enqueue_style('dzs.scroller', $this->thepath . 'dzsscroller/scroller.css');
        wp_enqueue_script('dzs.scroller', $this->thepath . 'dzsscroller/scroller.js');
        wp_enqueue_style('dzs.dzstoggle', $this->thepath . 'dzstoggle/dzstoggle.css');
        wp_enqueue_script('dzs.dzstoggle', $this->thepath . 'dzstoggle/dzstoggle.js');
        wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');
        wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');
    }

    function front_scripts() {
        //print_r($this->mainoptions);
        $scrollergalleryscripts = array('jquery');
        wp_enqueue_script('jquery');
        wp_enqueue_style('dzs.scroller', $this->thepath . "dzsscroller/scroller.css");
        wp_enqueue_style('dzs.scrollergallery', $this->thepath . "dzsscroller/scrollergallery.css");
        wp_enqueue_script('dzs.scroller', $this->thepath . "dzsscroller/scroller.js", $scrollergalleryscripts);
        wp_enqueue_script('dzs.scrollergallery', $this->thepath . "dzsscroller/scrollergallery.js", $scrollergalleryscripts);
        wp_enqueue_style('dzs.zoombox', $this->thepath . "zoombox/zoombox.css");
        wp_enqueue_script('dzs.zoombox', $this->thepath . "zoombox/zoombox.js");


        if ($this->mainoptions['embed_prettyphoto'] == 'on') {
            //wp_enqueue_script('jquery.prettyphoto', $this->thepath . "prettyphoto/jquery.prettyPhoto.js");
            //wp_enqueue_style('jquery.prettyphoto', $this->thepath . 'prettyphoto/prettyPhoto.css');
        }
        
        
        if($this->mainoptions['embed_masonry']=='on'){
            wp_enqueue_script('jquery.masonry', $this->thepath . "masonry/jquery.masonry.min.js");
        }
    }


function add_simple_field($pname, $otherargs = array()) {
    global $data;
    $fout = '';
    $val = '';
    
    $args = array(
        'val' => ''
    );
    $args = array_merge($args, $otherargs);
    
    $val = $args['val'];
    
    //====check if the data from database txt corresponds
    if (isset($data[$pname])){
        $val = $data[$pname];
    }
    $fout.='<div class="setting"><input type="text" class="textinput short" name="' . $pname . '" value="' . $val . '"></div>';
    echo $fout;
}

function add_cb_field($pname) {
    global $data;
    $fout = '';
    $val = '';
    if (isset($data[$pname]))
        $val = $data[$pname];
    $checked = '';
    if($val=='on')
        $checked=' checked';
    
    $fout.='<div class="setting"><input type="checkbox" class="textinput" name="' . $pname . '" value="on" '.$checked.'/> on</div>';
    echo $fout;
}

function add_cp_field($pname, $otherargs = array()) {
    global $data;
    $fout = '';
    $val = '';
    
    
    $args = array(
        'val' => ''
    );
    
    $args = array_merge($args, $otherargs);
    
    
    
    //print_r($args);
    $val = $args['val'];
    
    //====check if the data from database txt corresponds
    if (isset($data[$pname])){
        $val = $data[$pname];
    }
    
    $fout.='
<div class="setting"><input type="text" class="textinput short with_colorpicker" name="' . $pname . '" value="' . $val . '">
<div class="picker-con"><div class="the-icon"></div><div class="picker"></div></div>
</div>';
    echo $fout;
}
    function misc_input_text($argname, $argopts){
        $fout = '';
        $fout.='<input type="text"';
        $fout.=' name="'.$argname.'"';
        if(isset($argopts['seekval'])){
                $fout.=' value="'.$argopts['seekval'].'"';
            }
        
        $fout.='/>';
        return $fout;
    }
    function misc_input_checkbox($argname, $argopts){
        $fout = '';
        $auxtype = 'checkbox';
        
        if(isset($argopts['type'])){
            if($argopts['type']=='radio'){
                $auxtype = 'radio';
            }
        }
        $fout.='<input type="'.$auxtype.'"';
        $fout.=' name="'.$argname.'"';
        if(isset($argopts['class'])){
            $fout.=' class="'.$argopts['class'].'"';
        }
        $theval = 'on';
        if(isset($argopts['val'])){
            $fout.=' value="'.$argopts['val'].'"';
            $theval = $argopts['val'];
        }else{
            $fout.=' value="on"';
        }
        //print_r($this->mainoptions); print_r($argopts['seekval']);
        if(isset($argopts['seekval'])){
            $auxsw=false;
            if(is_array($argopts['seekval'])){
                //echo 'ceva'; print_r($argopts['seekval']);
                foreach($argopts['seekval'] as $opt){
                    //echo 'ceva'; echo $opt; echo 
                    if($opt == $argopts['val'] ){
                        $auxsw=true;
                    }
                }
            }else{
                //echo $argopts['seekval']; echo $theval;
                if($argopts['seekval']==$theval){
                    //echo $argval;
                    $auxsw=true;
                }
            }
            if($auxsw==true){
                $fout.=' checked="checked"';
            }
        }
        $fout.='/>';
        return $fout;
    }
    function admin_page_mainoptions(){
        //print_r($this->mainoptions);
        if(isset($_POST['dzssg_delete_plugindata']) && $_POST['dzssg_delete_plugindata']=='on'){
//            print_r($this->dbs);
            
            foreach($this->dbs as $db){
                if($db=='main'){
                    $db = '';
                }else{
                    $db = '-'.$db;
                }
                delete_option('dzssg_items'.$db);
            };
            
            delete_option('dzssg_dbs');
            delete_option('dzssg_options');
        }
        ?>
        
        <div class="wrap">
                <h2><?php echo __('Scroller Gallery Main Settings','dzssg'); ?></h2>
                <br/>
            <form class="mainsettings">
                
                <h3>Admin Options</h3>
                <div class="setting">
                    <div class="label"><?php echo __('do not use wordpres uploader','dzssg'); ?></div>
                    <?php echo $this->misc_input_checkbox('usewordpressuploader', array('val'=>'off', 'seekval' => $this->mainoptions['usewordpressuploader'])); ?>
                </div>
                
                <div class="setting">
                    <div class="label"><?php echo __('Use External wp-content Upload Directory ?','dzssg'); ?></div>
                    <?php echo $this->misc_input_checkbox('use_external_uploaddir', array('val'=>'on', 'seekval' => $this->mainoptions['use_external_uploaddir'])); ?>
                <div class="sidenote"><?php echo __('use an outside directory for uploading files','dzssg'); ?></div>
               </div>
                
                <div class="setting">
                    <div class="label"><?php echo __('Always Embed Scripts?','dzssg'); ?></div>
                    <?php echo $this->misc_input_checkbox('always_embed', array('val'=>'on', 'seekval' => $this->mainoptions['always_embed'])); ?>
                    <div class="sidenote"><?php echo __('by default scripts and styles from this gallery are included only when needed for optimizations reasons, but you can choose to always use them ( useful for when you are using a ajax theme that does not reload the whole page on url change )','dzssg'); ?></div>
                </div>
                
                <div class="setting">
                    <div class="label"><?php echo __('Fast binding?','dzssg'); ?></div>
                    <?php echo $this->misc_input_checkbox('is_safebinding', array('val'=>'off', 'seekval' => $this->mainoptions['is_safebinding'])); ?>
                    <div class="sidenote"><?php echo __('the galleries admin can use a complex ajax backend to ensure fast editing, but this can cause limitation issues on php servers. Turn this to on if you want a faster editing experience ( and if you have less then 20 videos accross galleries ) ','dzssg'); ?></div>
                </div>
                <br/>
                <a href='#' class="button-primary save-btn save-mainoptions"><?php echo __('Save Options','dzssg'); ?></a>
            </form>
            <br/><br/>
            <form class="mainsettings" method="POST">
                <button name="dzssg_delete_plugindata" value="on" class="button-secondary"><?php echo __('Delete Plugin Data', 'dzssg'); ?></button>
            </form>
        <div class="saveconfirmer" style=""><img alt="" style="" id="save-ajax-loading2" src="<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif"/></div>
        <script>
            jQuery(document).ready(function($){
                sliders_ready();
                $('input:checkbox').checkbox();
            })
            </script>
        </div>
              <div class="clear"></div><br/>
    <?php
    }
    function admin_page(){
        ?>
        <div class="wrap">
            <div class="import-export-db-con">
                <div class="the-toggle"></div>
                <div class="the-content-mask" style="">

                    <div class="the-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="one_half">
                                <h3>Import Database</h3>
                                <input name="dzssg_importdbupload" type="file" size="10"/><br />
                            </div>
                            <div class="one_half last alignright">
                                <input class="button-secondary" type="submit" name="dzssg_importdb" value="Import" />
                            </div>
                            <div class="clear"></div>
                        </form>


                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="one_half">
                                <h3>Import Slider</h3>
                                <input name="importsliderupload" type="file" size="10"/><br />
                            </div>
                            <div class="one_half last alignright">
                                <input class="button-secondary" type="submit" name="dzssg_importslider" value="Import" />
                            </div>
                            <div class="clear"></div>
                        </form>

                        <div class="one_half">
                            <h3>Export Database</h3>
                        </div>
                        <div class="one_half last alignright">
                            <form action="" method="POST"><input class="button-secondary" type="submit" name="dzssg_exportdb" value="Export"/></form>
                        </div>
                        <div class="clear"></div>

                    </div>
                </div>
            </div>
            <h2>DZS <?php _e('Scroller Gallery Admin', 'dzssg'); ?> <img alt="" style="visibility: visible;" id="main-ajax-loading" src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/></h2>
            <noscript><?php _e('You need javascript for this.', 'dzssg'); ?></noscript>
            <div class="top-buttons">
                <div class="super-select db-select dzssg"><button class="button-secondary btn-show-dbs">Current Database - <span class="strong currdb"><?php
if($this->currDb==''){
    echo 'main';
}else{
    echo $this->currDb;
}
                ?></span></button>
                    <select class="main-select hidden"><?php
                    //print_r($this->dbs);
                    
                    if(is_array($this->dbs)){
                        foreach($this->dbs as $adb){
                        $params = array( 'dbname' => $adb );
                        $newurl = add_query_arg( $params, dzs_curr_url() );
                            echo '<option' . ' data-newurl="' . $newurl . '"' . '>' . $adb . '</option>';
                        }
                    }else{
                        $params = array( 'dbname' => 'main' );
                        $newurl = add_query_arg( $params, dzs_curr_url() );
                        echo '<option' . ' data-newurl="' . $newurl . '"' . ' selected="selected"' . '>' . $adb . '</option>';
                    }
                    ?></select><div class="hidden replaceurlhelper"><?php
                        $params = array( 'dbname' => 'replaceurlhere' );
                        $newurl = add_query_arg( $params, dzs_curr_url() );
                        echo $newurl;
                    ?></div>
                </div>
            </div>
            <table cellspacing="0" class="wp-list-table widefat dzs_admin_table main_sliders">
                <thead> 
                    <tr> 
                        <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('ID', 'dzssg'); ?></th>
                        <th class="column-edit">Edit</th>
                        <th class="column-edit">Embed</th>
                        <th class="column-edit">Export</th>
                        <?php 
                if($this->mainoptions['is_safebinding']!='on'){
                    ?>
                        <th class="column-edit">Duplicate</th> 
                        <?php 
                }
                    ?>
                        <th class="column-edit">Delete</th> 
                    </tr> 
                </thead> 
                <tbody>
                </tbody>
            </table>
            <?php
            $url_add = '';
            $url_add = '';
        $items = $this->mainitems;
            //echo count($items);
        
        $aux = remove_query_arg( 'deleteslider', dzs_curr_url() );
        $params = array( 'currslider' => count($items));
        $url_add = add_query_arg( $params, $aux );
            
            ?>
            <a class="button-secondary add-slider" href="<?php echo $url_add; ?>"><?php _e('Add Slider', 'dzssg'); ?></a>
            <form class="master-settings">
            </form>
<div class="dzs-multi-upload">
<h3>Choose file(s)</h3>
<div>
	<input id="files-upload" class="multi-uploader" name="file_field" type="file" multiple>
</div>
<div class="droparea">
	<div class="instructions">drag & drop files here</div>
</div>
<div class="upload-list-title">The Preupload List</div>
<ul class="upload-list">
	<li class="dummy">add files here from the button or drag them above</li>
</ul>
<button class="primary-button upload-button">Upload All</button>
</div>
            <div class="notes">
                <div class="curl">Curl: <?php echo function_exists('curl_version') ? 'Enabled' : 'Disabled' . '<br />'; ?>
                </div>
                <div class="fgc">File Get Contents: <?php echo ini_get('allow_url_fopen') ? "Enabled" : "Disabled"; ?>
                </div>
                <div class="sidenote"><?php _e('If neither of these are enabled, only normal feed will work. 
                    Contact your host provider on how to enable these services to use the YouTube User Channel 
                    or YouTube Playlist feed.', 'dzssg'); ?>
                </div>
            </div>
            <div class="saveconfirmer"><?php _e('Loading...', 'dzssg'); ?></div>
            <a href="#" class="button-primary master-save"></a> <img alt="" style="position:fixed; bottom:18px; right:125px; visibility: hidden;" id="save-ajax-loading" src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/>

    <a href="#" class="button-primary master-save"><?php _e('Save All Galleries', 'dzssg'); ?></a>
    <a href="#" class="button-primary slider-save"><?php _e('Save Gallery', 'dzssg'); ?></a>
        </div>
        <script>
        <?php
//$jsnewline = '\\' + "\n";
        if(isset($this->mainoptions['use_external_uploaddir']) && $this->mainoptions['use_external_uploaddir']=='on'){
        echo "window.dzs_upload_path = '" . site_url('wp-content') . "/upload/';
";
        echo "window.dzs_phpfile_path = '" . site_url('wp-content') . "/upload.php';
";
            
        }else{
        echo "window.dzs_upload_path = '" . $this->thepath . "admin/upload/';
";
        echo "window.dzs_phpfile_path = '" . $this->thepath . "admin/upload.php';
";
        }
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->sliderstructure);
        echo "var sliderstructure = '" . $aux . "';
";
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->itemstructure);
        echo "var itemstructure = '" . $aux . "';
";
        ?>
            jQuery(document).ready(function($){
                sliders_ready();
                if(jQuery.fn.multiUploader){
                jQuery('.dzs-multi-upload').multiUploader();
                }
        <?php
        $items = $this->mainitems;
        for ($i = 0; $i < count($items); $i++) {
            //print_r($items[$i]);
            $aux = '';
            if(isset($items[$i]) && isset($items[$i]['settings']) && isset($items[$i]['settings']['id'])){
                //echo $items[$i]['settings']['id'];
                $aux = '{ name: "'.$items[$i]['settings']['id'].'"}';
            }
            echo "sliders_addslider(".$aux.");";
        }
        if (count($items) > 0)
            echo 'sliders_showslider(0);';
        for ($i = 0; $i < count($items); $i++) {
            //echo $i . $this->currSlider . 'cevava';
            if(($this->mainoptions['is_safebinding']!='on' || $i==$this->currSlider) && is_array($items[$i])){
                
                //==== jsi is the javascript I, if safebinding is on then the jsi is always 0 ( only one gallery ) 
                $jsi = $i;
                if($this->mainoptions['is_safebinding']=='on'){
                    $jsi = 0;
                }
                
                for ($j = 0; $j < count($items[$i]) - 1; $j++) {
                    echo "sliders_additem(" . $jsi . ");";
                }
                
                foreach ($items[$i] as $label => $value) {
                    if ($label === 'settings') {
                        if(is_array($items[$i][$label])){
                            foreach ($items[$i][$label] as $sublabel => $subvalue) {
                                $subvalue = (string)$subvalue;
                                $subvalue = stripslashes($subvalue);
                                $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                                $subvalue = str_replace(array("'"), '"', $subvalue);
                                echo 'sliders_change(' . $jsi . ', "settings", "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                            }
                        }
                    } else {

                        if(is_array($items[$i][$label])){
                        foreach ($items[$i][$label] as $sublabel => $subvalue) {
                                $subvalue = (string)$subvalue;
                            $subvalue = stripslashes($subvalue);
                            $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                            $subvalue = str_replace(array("'"), '"', $subvalue);
                            if ($label == '') {
                                $label = '0';
                            }
                            echo 'sliders_change(' . $jsi . ', ' . $label . ', "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                        }
                        }
                    }
                }
                if($this->mainoptions['is_safebinding']=='on'){
                    break;
                }
            }
        }
        ?>
                jQuery('#main-ajax-loading').css('visibility', 'hidden');
                if(window.dzssg_settings!=undefined && dzssg_settings.is_safebinding=="on"){
                    jQuery('.master-save').remove();
                    if(dzssg_settings.addslider=="on"){
                    //console.log(dzssg_settings.addslider)
                        sliders_addslider();
                        window.currSlider_nr=-1
                        sliders_showslider(0);
                    }
                    jQuery('.slider-in-table').each(function(){
                        jQuery(this).children('.button_view').eq(3).remove();
                    });
                }
            check_global_items();
            });     
        </script>
        <?php
    }

    function post_options() {
        //// POST OPTIONS ///

        if (isset($_POST['dzssg_exportdb'])) {
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . "dzssg_backup.txt" . '"');
            echo serialize($this->mainitems);
            die();
        }

        if (isset($_POST['dzssg_exportslider'])) {
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . "dzssg-slider-" . $_POST['slidername'] . ".txt" . '"');
            //print_r($_POST);
            echo serialize($this->mainitems[$_POST['slidernr']]);
            die();
        }


        if (isset($_POST['dzssg_importdb'])) {
            //print_r( $_FILES);
            $file_data = file_get_contents($_FILES['dzssg_importdbupload']['tmp_name']);
            $this->mainitems = unserialize($file_data);
            update_option($this->dbitemsname, $this->mainitems);
        }

        if (isset($_POST['dzssg_importslider'])) {
            //print_r( $_FILES);
            $file_data = file_get_contents($_FILES['importsliderupload']['tmp_name']);
            $auxslider = unserialize($file_data);
            //replace_in_matrix('http://localhost/wpmu/eos/wp-content/themes/eos/', THEME_URL, $this->mainitems);
            //replace_in_matrix('http://eos.digitalzoomstudio.net/wp-content/themes/eos/', THEME_URL, $this->mainitems);
            //echo 'ceva';
            //print_r($auxslider);
            $this->mainitems = get_option($this->dbitemsname);
            //print_r($this->mainitems);
            $this->mainitems[] = $auxslider;

            update_option($this->dbitemsname, $this->mainitems);
        }

    }

    function post_save_mo() {
        $auxarray = array();
        //parsing post data
        parse_str($_POST['postdata'], $auxarray);
        print_r($auxarray);
        
        if($auxarray['use_external_uploaddir']=='on'){

            $path_uploadfile = dirname(dirname(dirname(__FILE__))).'/upload.php';
            if(file_exists($path_uploadfile) === false){
            copy(dirname(__FILE__).'/admin/upload.php', $path_uploadfile);
            }
            $path_uploaddir = dirname(dirname(dirname(__FILE__))) . '/upload'; 
            if(is_dir($path_uploaddir) === false){
                mkdir($path_uploaddir,0777);
            }
        }
        
        update_option($this->dboptionsname, $auxarray);
        die();
    }
    function post_save() {
        //---this is the main save function which saves item
        $auxarray = array();
        $mainarray = array();
        
        //print_r($this->mainitems);
        //print_r($_POST['postdata']);
        
        //parsing post data
        parse_str($_POST['postdata'], $auxarray);
        
        
        if (isset($_POST['currdb'])) {
            $this->currDb = $_POST['currdb'];
        }
        //echo 'ceva'; print_r($this->dbs);
        if($this->currDb!='main' && $this->currDb!=''){
            $this->dbitemsname.='-'.$this->currDb;
        }
        //echo $this->dbitemsname;
        if(isset($_POST['sliderid'])){
            //print_r($auxarray);
            $mainarray= get_option($this->dbitemsname);
            foreach($auxarray as $label => $value){
                $aux = explode('-', $label);
                $tempmainarray[$aux[1]][$aux[2]] = $auxarray[$label];
            }
            $mainarray[$_POST['sliderid']] = $tempmainarray;
        }else{
            foreach ($auxarray as $label => $value) {
                //echo $auxarray[$label];
                $aux = explode('-', $label);
                $mainarray[$aux[0]][$aux[1]][$aux[2]] = $auxarray[$label];
            }
        }
        //echo $this->dbitemsname; print_r($_POST); print_r($this->currDb); echo isset($_POST['currdb']);
        update_option($this->dbitemsname, $mainarray);
        echo 'success';
        print_r($mainarray);
        die();
    }


}