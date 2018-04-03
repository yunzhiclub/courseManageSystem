<?php
/**
 * Created by PhpStorm.
 * User: panjie
 * Date: 2018/4/3
 * Time: 上午8:46
 */

namespace app\index\input;

/**
 * Class Github
 * @package app\index\input
 * 获取github的推送数据
 */
class GithubInput
{
    private $jsonObject;

    public function isMerged() {
        if ($this->jsonObject->pull_request->merged) {                   // 如果merged属性为true
            return true;                                     // 返回真
        } else {
            return false;                                    // 返回假
        }
    }

    static function fromJsonString($jsonString){
        $jsonObject = json_decode($jsonString);
        return self::fromJsonObject($jsonObject);
    }

    static function fromJsonObject($jsonObject) {
        $githubInput = new self();
        $githubInput->setJsonObject($jsonObject);
        return $githubInput;
    }

    public function getSource() {
        return $this->jsonObject->repository->name;
    }

    /**
     * @return mixed
     */
    public function getJsonObject()
    {
        return $this->jsonObject;
    }

    /**
     * @param mixed $jsonObject
     */
    public function setJsonObject($jsonObject)
    {
        $this->jsonObject = $jsonObject;
    }

    public function getUserName()
    {
        return $this->jsonObject->pull_request->user->login;
    }

    public function getContribution()
    {
        $title = $this->jsonObject->pull_request->title;
        return self::getContributionInStr($title);         // 获取标题字符串中的数字
    }

    public function getPullRequest() {
        return $this->getJsonObject()->pull_request;
    }

    public function getUrl() {
        return $this->getPullRequest()->html_url;
    }

    public function getTitle() {
        return $this->getPullRequest()->title;
    }

    public function getNumber()
    {
        return $this->getJsonObject()->number;
    }
}