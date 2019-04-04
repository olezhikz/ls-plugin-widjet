<?php

class PluginSubscribe_ModuleSubscribe_EntitySubscribe extends EntityORM
{
    
    protected $aRelations = array(
        'event' => array( self::RELATION_TYPE_BELONGS_TO, 'PluginSubscribe_ModuleSubscribe_EntityEvent', 'event_id' )
    );
    
    protected $aValidateRules = [
        ['user_id event_id', 'subscribe_exists']
    ];
    
    public function ValidateSubscribeExists($mValue) {
        $oSubscribe = $this->PluginSubscribe_Subscribe_GetSubscribeByFilter( [
            'user_id' => $this->getUserId(),
            'event_id'  => $this->getEventId()
        ]);
        
        if($oSubscribe){
            if($oEvent = $this->PluginSubscribe_Subscribe_GetEventById( $this->getEventId() )){
                return $this->Lang_Get(
                    'plugin.subscribe.subscribe.notices.error_validate_exists',
                    [ 'event_name' => $oEvent->getTitle()]
                );
            }
            return $this->Lang_Get('plugin.subscribe.subscribe.notices.error_validate_exists');
        }
        return true;
    }
}