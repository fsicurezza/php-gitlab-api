<?php namespace Gitlab\Api;

class Projects extends AbstractApi
{
    const ORDER_BY = 'created_at';
    const SORT = 'asc';

    /**
     * @param int $page
     * @param int $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function all($page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT)
    {
        return $this->get('projects/all', array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
    }

    /**
     * @param int $page
     * @param int $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function accessible($page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT)
    {
        return $this->get('projects', array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
    }

    /**
     * @param int $page
     * @param int $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function owned($page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT)
    {
        return $this->get('projects/owned', array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
    }

    /**
     * Get a list of projects which are starred by the authenticated user.
     *
     * @param int $page             Page number
     * @param int $per_page         Number of starred projects per page
     * @param null $archived        if passed, limit by archived status
     * @param null $visibility      if passed, limit by visibility public, internal, private
     * @param string $order_by      Return requests ordered by id, name, path, created_at, updated_at or last_activity_at fields. Default is created_at
     * @param string $sort          Return requests sorted in asc or desc order. Default is desc
     * @param null $search          Return list of authorized projects according to a search criteria
     * @return mixed
     */
    public function starred($page = 1, $per_page = self::PER_PAGE, $archived = null, $visibility = null, $order_by = self::ORDER_BY, $sort = self::SORT, $search = null)
    {
        return $this->get('projects/starred', array(
            'page' => $page,
            'per_page' => $per_page,
            'archived' => $archived,
            'visibility' => $visibility,
            'order_by' => $order_by,
            'sort' => $sort,
            'search' => $search
        ));
    }

    /**
     * @param string $query
     * @param int $page
     * @param int $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function search($query, $page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT)
    {
        return $this->get('projects/search/'.$this->encodePath($query), array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
    }

    /**
     * @param int $project_id
     * @return mixed
     */
    public function show($project_id)
    {
        return $this->get('projects/'.$this->encodePath($project_id));
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public function create($name, array $params = array())
    {
        $params['name'] = $name;

        return $this->post('projects', $params);
    }

    /**
     * @param int $user_id
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public function createForUser($user_id, $name, array $params = array())
    {
        $params['name'] = $name;

        return $this->post('projects/user/'.$this->encodePath($user_id), $params);
    }

    /**
     * @param int $project_id
     * @param array $params
     * @return mixed
     */
    public function update($project_id, array $params)
    {
        return $this->put('projects/'.$this->encodePath($project_id), $params);
    }

    /**
     * @param int $project_id
     * @return mixed
     */
    public function remove($project_id)
    {
        return $this->delete('projects/'.$this->encodePath($project_id));
    }

    /**
     * @param int $project_id
     * @param array $scope
     * @return mixed
     */
    public function builds($project_id, $scope = null)
    {
        return $this->get($this->getProjectPath($project_id, 'builds'), array(
            'scope' => $scope
        ));
    }

    /**
     * @param $project_id
     * @param $build_id
     * @return mixed
     */
    public function build($project_id, $build_id)
    {
        return $this->get($this->getProjectPath($project_id, 'builds/'.$this->encodePath($build_id)));
    }

    /**
     * @param $project_id
     * @param $build_id
     * @return mixed
     */
    public function trace($project_id, $build_id)
    {
        return $this->get($this->getProjectPath($project_id, 'builds/'.$this->encodePath($build_id).'/trace'));
    }

    /**
     * @param int $project_id
     * @param string $username_query
     * @return mixed
     */
    public function members($project_id, $username_query = null)
    {
        return $this->get($this->getProjectPath($project_id, 'members'), array(
            'query' => $username_query
        ));
    }

    /**
     * @param int $project_id
     * @param int $user_id
     * @return mixed
     */
    public function member($project_id, $user_id)
    {
        return $this->get($this->getProjectPath($project_id, 'members/'.$this->encodePath($user_id)));
    }

    /**
     * @param int $project_id
     * @param int $user_id
     * @param int $access_level
     * @return mixed
     */
    public function addMember($project_id, $user_id, $access_level)
    {
        return $this->post($this->getProjectPath($project_id, 'members'), array(
            'user_id' => $user_id,
            'access_level' => $access_level
        ));
    }

    /**
     * @param int $project_id
     * @param int $user_id
     * @param int $access_level
     * @return mixed
     */
    public function saveMember($project_id, $user_id, $access_level)
    {
        return $this->put($this->getProjectPath($project_id, 'members/'.urldecode($user_id)), array(
            'access_level' => $access_level
        ));
    }

    /**
     * @param int $project_id
     * @param int $user_id
     * @return mixed
     */
    public function removeMember($project_id, $user_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'members/'.urldecode($user_id)));
    }

    /**
     * @param int $project_id
     * @param int $page
     * @param int $per_page
     * @return mixed
     */
    public function hooks($project_id, $page = 1, $per_page = self::PER_PAGE)
    {
        return $this->get($this->getProjectPath($project_id, 'hooks'), array(
            'page' => $page,
            'per_page' => $per_page
        ));
    }

    /**
     * @param int $project_id
     * @param int $hook_id
     * @return mixed
     */
    public function hook($project_id, $hook_id)
    {
        return $this->get($this->getProjectPath($project_id, 'hooks/'.$this->encodePath($hook_id)));
    }

    /**
     * @param int $project_id
     * @param string $url
     * @param array $params
     * @return mixed
     */
    public function addHook($project_id, $url, array $params = array())
    {
        if (empty($params)) {
            $params = array('push_events' => true);
        }

        $params['url'] = $url;

        return $this->post($this->getProjectPath($project_id, 'hooks'), $params);
    }

    /**
     * @param int $project_id
     * @param int $hook_id
     * @param array $params
     * @return mixed
     */
    public function updateHook($project_id, $hook_id, array $params)
    {
        return $this->put($this->getProjectPath($project_id, 'hooks/'.$this->encodePath($hook_id)), $params);
    }

    /**
     * @param int $project_id
     * @param int $hook_id
     * @return mixed
     */
    public function removeHook($project_id, $hook_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'hooks/'.$this->encodePath($hook_id)));
    }

    /**
     * @param int $project_id
     * @return mixed
     */
    public function keys($project_id)
    {
        return $this->get($this->getProjectPath($project_id, 'keys'));
    }

    /**
     * @param int $project_id
     * @param int $key_id
     * @return mixed
     */
    public function key($project_id, $key_id)
    {
        return $this->get($this->getProjectPath($project_id, 'keys/'.$this->encodePath($key_id)));
    }

    /**
     * @param int $project_id
     * @param string $title
     * @param string $key
     * @return mixed
     */
    public function addKey($project_id, $title, $key)
    {
        return $this->post($this->getProjectPath($project_id, 'keys'), array(
            'title' => $title,
            'key' => $key
        ));
    }

    /**
     * @param int $project_id
     * @param int $key_id
     * @return mixed
     */
    public function removeKey($project_id, $key_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'keys/'.$this->encodePath($key_id)));
    }

    /**
     * @param int $project_id
     * @param int $page
     * @param int $per_page
     * @return mixed
     */
    public function events($project_id, $page = 1, $per_page = self::PER_PAGE)
    {
        return $this->get($this->getProjectPath($project_id, 'events'), array(
            'page' => $page,
            'per_page' => $per_page
        ));
    }

    /**
     * @param int $project_id
     * @return mixed
     */
    public function labels($project_id)
    {
        return $this->get($this->getProjectPath($project_id, 'labels'));
    }

    /**
     * @param int $project_id
     * @param array $params
     * @return mixed
     */
    public function addLabel($project_id, array $params)
    {
        return $this->post($this->getProjectPath($project_id, 'labels'), $params);
    }

    /**
     * @param int $project_id
     * @param array $params
     * @return mixed
     */
    public function updateLabel($project_id, array $params)
    {
        return $this->put($this->getProjectPath($project_id, 'labels'), $params);
    }

    /**
     * @param int $project_id
     * @param string $name
     * @return mixed
     */
    public function removeLabel($project_id, $name)
    {
        return $this->delete($this->getProjectPath($project_id, 'labels'), array(
            'name' => $name
        ));
    }

    /**
     * @param int $project_id
     * @param int $forked_project_id
     * @return mixed
     */
    public function createForkRelation($project_id, $forked_project_id)
    {
        return $this->post($this->getProjectPath($project_id, 'fork/'.$this->encodePath($forked_project_id)));
    }

    /**
     * @param int $project_id
     * @return mixed
     */
    public function removeForkRelation($project_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'fork'));
    }

    /**
     * @param int $project_id
     * @param string $service_name
     * @param array $params
     * @return mixed
     */
    public function setService($project_id, $service_name, array $params = array())
    {
        return $this->put($this->getProjectPath($project_id, 'services/'.$this->encodePath($service_name)), $params);
    }

    /**
     * @param int $project_id
     * @param string $service_name
     * @return mixed
     */
    public function removeService($project_id, $service_name)
    {
        return $this->delete($this->getProjectPath($project_id, 'services/'.$this->encodePath($service_name)));
    }

    /**
     * @param $project_id
     * @param $sha
     * @param $state            The state of the status. Can be one of the following: pending, running, success, failed, canceled
     * @param array $params     name or context (string) = The label to differentiate this status from the status of other systems. Default value is default
     *                          target_url (string) = The target URL to associate with this status
     *                          description (string) = 	The short description of the status
     * @return mixed
     */
    public function createStatus($project_id, $sha, $state, array $params = array())
    {
        $params['state'] = $state;
        return $this->post($this->getProjectPath($project_id, 'statuses/'.$this->encodePath($sha)), $params);
    }

}
