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
 * @author panjie
 */
class GithubInput
{
    private $jsonObject;

    /**
     * @return bool
     * 是否同意合并
     */
    public function isMerged() {
        if ($this->jsonObject->pull_request->merged) {                   // 如果merged属性为true
            return true;                                     // 返回真
        } else {
            return false;                                    // 返回假
        }
    }

    /**
     * @param $jsonString
     * @return GithubInput
     * 由json数据获取本对象
     */
    static function fromJsonString($jsonString){
        $jsonObject = json_decode($jsonString);
        return self::fromJsonObject($jsonObject);
    }

    /**
     * @param $jsonObject
     * @return GithubInput
     * 由json对象获取本对象
     */
    static function fromJsonObject($jsonObject) {
        $githubInput = new self();
        $githubInput->setJsonObject($jsonObject);
        return $githubInput;
    }

    /**
     * @return mixed
     * 获取仓库名
     */
    public function getSource() {
        return $this->jsonObject->repository->name;
    }

    /**
     * @return mixed
     * 获取json对象
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

    /**
     * @return mixed
     * 获取github用户名
     */
    public function getUserName()
    {
        return $this->jsonObject->pull_request->user->login;
    }

    /**
     * @return Object
     * 获取pullRequest
     */
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