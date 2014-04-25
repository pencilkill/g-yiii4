<?php
/**
 *
 * @author Sam@ozchamp.net
 * use owner instead of Yii::app() to make behavior reusable for other modules
 *
 */
class BeforeRequestBehavior extends CBehavior
{
	/**
	 * The attachEventHandler() mathod attaches an event handler to an event.
	 * So: onBeginRequest, the backBeginRequest() method will be called.
	 */
	public function events()
    {
        $events=parent::events();

    	return CMap::mergeArray($events,array(
			'onBeginRequest'=>'beginRequest'
        ));
    }
    /**
     * We just called beginRequest()
     * Add any methods to beginRequest()
     * @see beginRequest()
     */
    public function beginRequest($event) {
    	//
    	$this->parseUrl();
    	// set current language for multiple languages
        $this->setMultiLanguage();
        // forece translation
        $this->setTranslation(true);
        /*
         *  theme base on language
         *
         *	or using 'File Translation' view file, e.g
         *  views/site/index.php for sourceLanguage while views/site/zh_tw/index.php for language 'zh_tw'
         *  File Translation support different something like image(s) for different language, not only 'Message Translation'
         */
        //$this->setTheme($this->owner->language);
    }
    /**
     *	required to get language query string if urlManager enabled
     */
    public function parseUrl(){
    	$pathInfo = $this->owner->getUrlManager()->parseUrl($this->owner->getRequest());

    	$this->owner->getUrlManager()->parsePathInfo($pathInfo);
    }
	/**
	 * language forceTranslation if using Yii::t()
	 * @param boolean $isForce
	 */
	public function setTranslation($isForce=true) {
		$this->owner->getMessages()->forceTranslation = $isForce;
	}
	/**
	 * set multilanguage using get method
	 */
	public function setMultiLanguage() {
		// default languageId
		if(! isset($this->owner->params->languageId)){
			$this->owner->params = CMap::mergeArray($this->owner->params, array('languageId' => null));
		}
		// default lanuageVar
		if(! isset($this->owner->params->languages)){
			$this->owner->params = CMap::mergeArray($this->owner->params, array('languages' => array()));
		}
		// default showLanuageVar
		if(! isset($this->owner->params->showLanguageVar)){
			$this->owner->params = CMap::mergeArray($this->owner->params, array('showLanguageVar' => false));
		}
		// default lanuageVar
		if(! isset($this->owner->params->languageVar)){
			$this->owner->params = CMap::mergeArray($this->owner->params, array('languageVar' => 'language'));
		}
		// default languageCookieVar
		if(! isset($this->owner->params->languageCookieVar)){
			$this->owner->params = CMap::mergeArray($this->owner->params, array('languageCookieVar' => '__language'));
		}


		$lanuageVar = $this->owner->params->languageVar;
		$languageCookieVar = $this->owner->params->languageCookieVar;
		/**
		 * usging param "language" of "get" method to set current language
		 */
		$languageCode = $this->owner->getRequest()->getParam($lanuageVar);

		// set language state
		if ($languageCode){
			// user state
            $this->owner->getUser()->setState($languageCookieVar, $languageCode);

            // cookie
            $cookie = new CHttpCookie($languageCookieVar, $languageCode);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            $this->owner->getRequest()->cookies[$languageCookieVar] = $cookie;
        } else if ($this->owner->getUser()->hasState($languageCookieVar)){
            $languageCode = $this->owner->getUser()->getState($languageCookieVar);
        } else if(isset($this->owner->getRequest()->cookies[$languageCookieVar])){
            $languageCode = $this->owner->getRequest()->cookies[$languageCookieVar]->value;
        }

        /**
         * @rechecking
         */
        $criteria = new CDbCriteria;
        $criteria->alias = 't';
		$criteria->index = 'code';
		$criteria->compare('t.status', '1');
		$criteria->order = "FIELD(t.code, '". $languageCode ."') DESC, t.sort_order DESC";

		$languages = Language::model()->findAll($criteria);

		// set languages
		$this->owner->params->languages = $languages;

		// finially language
		if($languages && key($languages)){
			$languageCode = key($languages);
		}

		$language = $languages[$languageCode];

		$this->owner->setLanguage($languageCode);

		// languageId
		$this->owner->params->languageId = $language->language_id;

		return true;
	}
	/**
	 * set current theme
	 * @param string $theme
	 */
	public function setTheme($theme=null){
		$this->owner->theme = $theme;
	}
}
?>