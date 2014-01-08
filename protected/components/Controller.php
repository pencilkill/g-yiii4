<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @var assetsUrl
	 */
	public $assetsUrl;

	/**
	 * see app behavior to get more about init()
	 */
	public function init() {
		parent::init();
		// default head
		$this->setDefaultMeta();
		// assetsUrl
		$this->assetsUrl = $this->assetsUrl();
	}

	/**
	 * This function override to handler url with language
	 * it depends on the app params configured in config/params.php whether to show language var automatic
	 * @see config/params.php
	 * @param $route
	 * @param $params
	 * @param $ampersand
	 */
	public function createUrl($route,$params=array(),$ampersand='&')
    {
    	/**
		 * default name is "language"
		 */
		$languageVar = isset(Yii::app()->params->languageVar)? Yii::app()->params->languageVar : null;
    	/**
		 * whether to show language query string
		 */
		$showLanguageVar = (isset(Yii::app()->params->showLanguageVar))? Yii::app()->params->showLanguageVar : false;

        if ($showLanguageVar){
	    	// append language param
         	$params[$languageVar] = Yii::app()->language;
        }else{
	        // to make a no language parameter url sometimes
        	unset($params[$languageVar]);
        }
        // create
        if($route===''){
            $route=$this->getId().'/'.$this->getAction()->getId();
        }
        else if(strpos($route,'/')===false){
            $route=$this->getId().'/'.$route;
        }
        if($route[0]!=='/' && ($module=$this->getModule())!==null){
            $route=$module->getId().'/'.$route;
        }
        return Yii::app()->createUrl(trim($route,'/'),$params,$ampersand);
    }

    /**
     * Set default page title, keywords, description
     * The core jquery script is not included, it will be registered in main layout if necessary
     * We can change title and meta dynamically using the meta unique id which is the fifth parameter for app registerMetaTag()
     */
    public function setDefaultMeta(){
    	$li = Yii::app()->params->languageId;
    	$mt = 'meta_title_'.$li;
    	$mk = 'meta_keywords_'.$li;
    	$md = 'meta_description_'.$li;

    	// title
    	$this->pageTitle = Yii::app()->config->get($mt);
    	// metaTags
    	Yii::app()->clientScript->registerMetaTag(Yii::app()->config->get($mk), 'keywords', null, null, 'keywords');
    	Yii::app()->clientScript->registerMetaTag(Yii::app()->config->get($md), 'description', null, null, 'description');
    }

    /**
     * Using to get assetsUrl dynamically
     * @see this->init()
     * @param $assets
     */
    public function assetsUrl($assets = 'assets'){
    	$publishPath = null;

    	if(empty($publishPath) && Yii::app()->theme && is_dir($path = Yii::app()->theme->basePath . DIRECTORY_SEPARATOR . $assets)){
	    	$publishPath = Yii::app()->assetManager->publish($path);
    	}

    	if(empty($publishPath) && is_dir($path = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $assets)){
	    	$publishPath = Yii::app()->baseUrl . '/' . $assets;
    	}

    	return $publishPath;
    }
/**
     * pdfable
     */
	public function enablePdfable($option = array(), $pageOptions = array(), $tmpAlias = null){
		Yii::import('frontend.extensions.pdfable.Pdfable');

		if(!isset($option['bin'])){
			if(strpos(strtolower($_SERVER['HTTP_HOST']),'local')!==false){
				$option['bin'] = 'D:\Program Files\wkhtmltopdf\wkhtmltopdf.exe';
			}elseif(strpos(strtolower($_SERVER['HTTP_HOST']),'works.tw')!==false){
				$option['bin'] = '/usr/local/bin/wkhtml2pdf';
			}else{
				$option['bin'] = '/usr/bin/wkhtml2pdf';
			}
		}

		if(isset($option['bin']) && is_file($option['bin'])){
			$this->attachBehavior('pdfable', 'Pdfable');

			$this->pdfable->setPdfOptions($option);
			$this->pdfable->setPdfPageOptions($pageOptions);
			if(empty($tmpAlias)){
				$tmpdir = Yii::getPathOfAlias('webroot.assets.pdfable');

				is_dir($tmpdir) || CFileHelper::mkdir($tmpdir);

				$this->pdfable->tmpAlias = 'webroot.assets.pdfable';
			}

			return true;
		}else{
			return false;
		}
	}
}