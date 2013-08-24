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
		/**
		 * set $langCookieName as custom brower cookie name which store current language
		 * default name is "language"
		 */
		$languageCookieName = (isset($this->owner->params['langCookieName']))?$this->owner->params['langCookieName']:'__language';
		/**
		 * usging param "language" of "get" method to set current language
		 */
		$language = $this->owner->getRequest()->getParam('language');

		if ($language){
            $this->owner->setLanguage($language);

            $this->owner->getUser()->setState($languageCookieName, $language);

            $cookie = new CHttpCookie($languageCookieName, $language);

            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)

            $this->owner->getRequest()->cookies[$languageCookieName] = $cookie;
        } else if ($this->owner->getUser()->hasState($languageCookieName)){
            $language = $this->owner->getUser()->getState($languageCookieName);
        } else if(isset($this->owner->getRequest()->cookies[$languageCookieName])){
            $language = $this->owner->getRequest()->cookies[$languageCookieName]->value;
        }

        /**
         * @rechecking
         */
        $criteria = new CDbCriteria;
		$criteria->index = 'code';
		$criteria->compare('status', '1');
		$criteria->order = "field(code, '".$this->owner->language."') desc, sort_id desc";

		$languages = Language::model()->findAll($criteria);

		if($languages && key($languages)){
			$this->owner->setLanguage(key($languages));
		}
	}

	public function setTheme($theme){
		$this->owner->theme = $theme;
	}
}
?>