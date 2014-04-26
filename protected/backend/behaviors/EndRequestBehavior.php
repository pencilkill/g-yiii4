<?php
/**
 *
 * @author Sam <mail.song.de.qiang@gmail.com>
 *
 */
class EndRequestBehavior extends CBehavior
{

	/**
	 * The attachEventHandler() mathod attaches an event handler to an event.
	 * So: onBeginRequest, the backBeginRequest() method will be called.
	 */
	public function events()
    {
        $events=parent::events();

    	return CMap::mergeArray($events,array(
			'onEndRequest'=>'endRequest'
        ));
    }
    /**
     * We just called endRequest()
     * Add any methods to endRequest()
     * @see beginRequest()
     */
    public function endRequest($event) {

    }

}
?>