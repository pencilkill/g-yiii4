<?php
/**
 *
 * @author Sam@ozchamp.net
 * use owner instead of Yii::app() to make behavior reusable for other modules
 *
 */
class BeforeRequestBehavior extends CBehavior
{
	private $_languageCookieVar = '__language';

	public function init(){
		parent::init();

		/**
		 * set $_langCookieVar as custom brower cookie name which store current language
		 * default name is "__language"
		 */
		$this->_languageCookieVar = (isset(Yii::app()->params->languageCookieVar))? Yii::app()->params->languageCookieVar :'__language';

	}
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
    	/**
    	 * The turns for setMultiLanguage() and setTranslation() should be important
    	 */
        $this->setMultiLanguage();
        // forece translation
        $this->setTranslation(true);
        // theme base on language
        $this->setTheme($this->owner->language);
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
		$lanuageVar = isset(Yii::app()->params->languageVar) ? Yii::app()->params->languageVar : '' ;
		/**
		 * usging param "language" of "get" method to set current language
		 */
		$languageCode = $this->owner->getRequest()->getParam($lanuageVar);

		// set language state
		if ($languageCode){
			// user state
            $this->owner->getUser()->setState($this->_languageCookieVar, $languageCode);

            // cookie
            $cookie = new CHttpCookie($this->_languageCookieVar, $languageCode);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            $this->owner->getRequest()->cookies[$this->_languageCookieVar] = $cookie;
        } else if ($this->owner->getUser()->hasState($this->_languageCookieVar)){
            $languageCode = $this->owner->getUser()->getState($this->_languageCookieVar);
        } else if(isset($this->owner->getRequest()->cookies[$this->_languageCookieVar])){
            $languageCode = $this->owner->getRequest()->cookies[$this->_languageCookieVar]->value;
        }

        /**
         * @rechecking
         */
        $criteria = new CDbCriteria;
		$criteria->index = 'code';
		$criteria->compare('status', '1');
		$criteria->order = "field(code, '". $languageCode ."') desc, sort_id desc";

		$languages = Language::model()->findAll($criteria);

		// set languages
		if(isset(Yii::app()->params->languages)){
			Yii::app()->params->languages = $languages;
		}else{
			CMap::mergeArray(Yii::app()->params, array('languages' => $languages));
		}

		// finially language
		if($languages && key($languages)){
			$languageCode = key($languages);
		}

		$language = $languages[$languageCode];

		$this->owner->setLanguage($languageCode);

		// languageId
		if(isset(Yii::app()->params->languageId)){
			Yii::app()->params->languageId = $language->language_id;
		}else{
			CMap::mergeArray(Yii::app()->params, array('languageId' => $language->language_id));
		}

		return true;
	}

	// set current theme
	public function setTheme($theme){
		$this->owner->theme = $theme;
	}

}
?>