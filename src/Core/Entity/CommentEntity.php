<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 24.04.17
 * Time: 14:16
 */
namespace Birthright\Core\Entity;
class CommentEntity
{
    private $user_id;

    private $parent_id;

    private $post_id;

    private $childs;

    private $created;

    private $text;

    private $id;

    public function __construct($user_id, $text, $post_id,  $parent_id = null,  $created = null, $id = null,$childs = [])
    {
        $this->user_id = $user_id;
        $this->text = $text;
        $this->post_id = $post_id;
        $this->parent_id = $parent_id;
        $this->childs = $childs;
        $this->created = $created;
        $this->id = $id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }


    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return array
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    public function setChilds(array $childs)
    {
        $this->childs = $childs;
    }

    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param null $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id)
    {
        $this->user_id = $user_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public static function objectVars($post): array
    {
        return get_object_vars($post);
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }


}