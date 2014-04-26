<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
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
        $this->setTranslation(true);
    }
	/**
	 * language forceTranslation if using Yii::t()
	 * @param boolean $isForce
	 */
	public function setTranslation($isForce=true) {
		Yii::app()->getMessages()->forceTranslation = $isForce;
	}
}
?>