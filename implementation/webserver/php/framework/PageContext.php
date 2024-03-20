<?php

/**
 * Class keeping models (and other data) that should be kept between page loads.
 */
class PageContext {
    /**
     * @const TTL
     * TimeToLive of single model in $_SESSION - how long should the session keep a model before deleting it.
     */
    const TTL = 60*60; // [s] = 1h
    /**
     * @var int $timeout
     *
     */
    public int $timeout;
    /**
     * @var array $contexts [FormContext]
     * Array of serialized models belonging to this page. Key to this array is formId.
     */
    public array $contexts = array();


    /**
     * Checks which page was sent to server, then loads all models of that page.
     * @return MModel|null Model matching submitted form. Null if formId was not found in $_POST. (Bad/no form submitted).
     */
    public static function loadAllModels():MModel|null {
        if (isset($_POST["pageId"])) {
            $pageId = $_POST["pageId"];
            return static::getPageContext($pageId)->loadPageModels();
        }
        return null;
    }

    /**
     * Adds new serialized model data $data of form $formId to current PageContext.
     * @param string $formId Id of model's form.
     * @param string $data Serialized model.
     * @return void
     */
    public function add(string $formId, string $data) {
        $this->contexts[$formId] = $data;
        $this->timeout = time()+static::TTL;
    }

    /**
     * Unserializes all models of this page (stored in $contexts, previously loaded from $_SESSION),
     * then updates their data.
     * @return MModel|null Model matching submitted form. Null if formId was not found in $_POST. (Bad/no form submitted).
     */
    public function loadPageModels() : MModel|null {
        $ret = null;
        foreach($this->contexts as $formId=>$ctx) {
            $context = unserialize($ctx); //FormContext
            if(isset($_POST["formId"]) && $_POST["formId"]==$formId) {
                $ret = $context->updateModel();
            }
            FormContext::setFormModel($formId, $context->model);
        }
        return $ret;
    }

    /**
     * Loads PageContext from $_SESSION, if not set, creates new.
     * @param string $pageId Id of page we want PageContext for.
     * @return PageContext
     */
    public static function getPageContext(string $pageId) : PageContext {
        if(!isset($_SESSION["pageContexts"])) $_SESSION["pageContexts"] = array();
        if(!isset($_SESSION["pageContexts"][$pageId])) $_SESSION["pageContexts"][$pageId] = new PageContext();
        return $_SESSION["pageContexts"][$pageId];
    }

    /**
     * Checks timeout of all page contexts. If passed, it is removed from $_SESSION.
     * @return void
     */
    public static function cleanup() : void {
        if(!isset($_SESSION["pageContexts"])) return;
        foreach ($_SESSION["pageContexts"] as $idx => $pageContext) {
            if (time() > $pageContext->timeout) unset($_SESSION["pageContexts"][$idx]);
        }
    }
}