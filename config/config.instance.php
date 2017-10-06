<?
/** reminderss
 */
Instance::set("reminders",BLL."reminders/","class.reminders","class_reminders");// 逻辑层
Instance::set("dai_reminders",DAI."reminders/","class.dai.reminders","class_dai_reminders");// 中介层
Instance::set("dal_reminders",DAL."reminders/","class.dal.reminders","class_dal_reminders");// 
Instance::set("error_reminders",WebPath_Func."io/error/");// 定义错误
/** tags
 */
Instance::set("tags",BLL."tags/","class.tags","class_tags");// 逻辑层
Instance::set("dai_tags",DAI."tags/","class.dai.tags","class_dai_tags");// 中介层
Instance::set("dal_tags",DAL."tags/","class.dal.tags","class_dal_tags");// 
Instance::set("error_tags",WebPath_Func."io/error/");// 定义错误
/** categorys
 */
Instance::set("categorys",BLL."categorys/","class.categorys","class_categorys");// 逻辑层
Instance::set("dai_categorys",DAI."categorys/","class.dai.categorys","class_dai_categorys");// 中介层
Instance::set("dal_categorys",DAL."categorys/","class.dal.categorys","class_dal_categorys");// 
Instance::set("error_categorys",WebPath_Func."io/error/");// 定义错误
?>