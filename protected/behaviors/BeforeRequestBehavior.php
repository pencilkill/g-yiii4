<?php
/**
 *
 * @author Sam@ozchamp.net
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
    	//$this->setAccessCheck();

    	/**
    	 * The turns for setMultiLanguage() and setTranslation() should be important
    	 */
        //$this->setMultiLanguage();

        $this->setTranslation(true);
    }
	/**
	 * accessrules for all request
	 * @param object $action
	 */
	public function setAccessCheck() {
		$route=Yii::app()->getUrlManager()->parseUrl(Yii::app()->getRequest());

        if(array_search($route, array('site/login','site/error','site/logout','site/captcha','gii/index'))===false)
        {
            if(Yii::app()->getUser()->isGuest){
                Yii::app()->getUser()->loginRequired();
            }
        }
	}
	/**
	 * language forceTranslation if using Yii::t()
	 * @param boolean $isForce
	 */
	public function setTranslation($isForce=true) {
		Yii::app()->getMessages()->forceTranslation = $isForce;
	}
	/**
	 * set multilanguage using get method
	 */
	public function setMultiLanguage() {
		/**
		 * set $langCookieName as custom brower cookie name which store current language
		 * default name is "language"
		 */
		$languageCookieName = (isset(Yii::app()->params['langCookieName']))?Yii::app()->params['langCookieName']:'__lang';
		/**
		 * usging param "language" of "get" method to set current language
		 */
		$language = Yii::app()->getRequest()->getParam('lang');

		if ($language){
            Yii::app()->setLanguage($language);

            Yii::app()->getUser()->setState($languageCookieName, $language);

            $cookie = new CHttpCookie($languageCookieName, $language);

            $cookie->expire = time() + (60*60*24*365); // (1 year)

            Yii::app()->getRequest()->cookies[$languageCookieName] = $cookie;
        }
        else if (Yii::app()->getUser()->hasState($languageCookieName)){
            $language = Yii::app()->getUser()->getState($languageCookieName);
        }
        else if(isset(Yii::app()->getRequest()->cookies[$languageCookieName])){
            $language = Yii::app()->getRequest()->cookies[$languageCookieName]->value;
        }

        /**
         * recheck
         */

        $language = array_key_exists($language, Yii::app()->params('languages')) ? $language : key(Yii::app()->params('languages'));

        Yii::app()->setLanguage($language);

	}
}
?>