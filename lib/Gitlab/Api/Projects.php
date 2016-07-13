<?php namespace Gitlab\Api;

class Projects extends AbstractApi
{
    const ORDER_BY = 'created_at';
    const SORT = 'asc';

    /**
     * Get a list of all GitLab projects (admin only).
     *
     * @param int $page
     * @param int $per_page
     * @param string $order_by      Return requests ordered by id, name, path, created_at, updated_at or last_activity_at fields. Default is created_at
     * @param string $sort          Return requests sorted in asc or desc order. Default is desc
     * @param array $params         archived (optional) - if passed, limit by archived status
     *                              visibility (optional) - if passed, limit by visibility public, internal, private
     *                              search (optional) - Return list of authorized projects according to a search criteria
     * @return mixed
     */
    public function all($page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT, $params = array())
    {
        $params = array_merge($params, array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
        return $this->get('projects/all', $params);
    }

    /**
     * Get a list of projects accessible by the authenticated user.
     *
     * @param int $page
     * @param int $per_page
     * @param string $order_by      Return requests ordered by id, name, path, created_at, updated_at or last_activity_at fields. Default is created_at
     * @param string $sort          Return requests sorted in asc or desc order. Default is desc
     * @param array $params         archived (optional) - if passed, limit by archived status
     *                              visibility (optional) - if passed, limit by visibility public, internal, private
     *                              search (optional) - Return list of authorized projects according to a search criteria
     * @return mixed
     */
    public function accessible($page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT, $params = array())
    {
        $params = array_merge($params, array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
        return $this->get('projects', $params);
    }

    /**
     * Get a list of projects which are owned by the authenticated user.
     *
     * @param int $page
     * @param int $per_page
     * @param string $order_by      order_by (optional) - Return requests ordered by id, name, path, created_at, updated_at or last_activity_at fields. Default is created_at
     * @param string $sort          sort (optional) - Return requests sorted in asc or desc order. Default is desc
     * @param array $params         archived (optional) - if passed, limit by archived status
     *                              visibility (optional) - if passed, limit by visibility public, internal, private
     *                              search (optional) - Return list of authorized projects according to a search criteria
     * @return mixed
     */
    public function owned($page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT, $params = array())
    {
        $params = array_merge($params, array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
        return $this->get('projects/owned', $params);
    }

    /**
     * Get a list of projects which are starred by the authenticated user.
     *
     * @param int $page
     * @param int $per_page
     * @param string $order_by      Return requests ordered by id, name, path, created_at, updated_at or last_activity_at fields. Default is created_at
     * @param string $sort          Return requests sorted in asc or desc order. Default is desc
     * @param array $params         archived (optional) - if passed, limit by archived status
     *                              visibility (optional) - if passed, limit by visibility public, internal, private
     *                              search (optional) - Return list of authorized projects according to a search criteria
     * @param null $search
     * @return mixed
     */
    public function starred($page = 1, $per_page = self::PER_PAGE, $order_by = self::ORDER_BY, $sort = self::SORT, $params = array())
    {
        $params = array_merge($params, array(
            'page' => $page,
            'per_page' => $per_page,
            'order_by' => $order_by,
            'sort' => $sort
        ));
        return $this->get('projects/starred', $params);
    }

    /**
     * Search for projects by name which are accessible to the authenticated user.
     *
     * @param string $query         A string contained in the project name
     * @param int $page             the page to retrieve
     * @param int $per_page         number of projects to return per page
     * @param string $order_by      Return requests ordered by id, name, created_at or last_activity_at fields
     * @param string $sort          Return requests sorted in asc or desc order
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
     * Get a specific project, identified by project ID or NAMESPACE/PROJECT_NAME, which is owned by the authenticated user.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @return mixed
     */
    public function show($project_id)
    {
        return $this->get('projects/'.$this->encodePath($project_id));
    }

    /**
     * Creates a new project owned by the authenticated user.
     *
     * @param string $name      new project name
     * @param array $params     path (optional) - custom repository name for new project. By default generated based on name
     *                          namespace_id (optional) - namespace for the new project (defaults to user)
     *                          description (optional) - short project description
     *                          issues_enabled (optional)
     *                          merge_requests_enabled (optional)
     *                          builds_enabled (optional)
     *                          wiki_enabled (optional)
     *                          snippets_enabled (optional)
     *                          container_registry_enabled (optional)
     *                          shared_runners_enabled (optional)
     *                          public (optional) - if true same as setting visibility_level = 20
     *                          visibility_level (optional)
     *                          import_url (optional)
     *                          public_builds (optional)
     * @return mixed
     */
    public function create($name, array $params = array())
    {
        $params['name'] = $name;

        return $this->post('projects', $params);
    }

    /**
     * Creates a new project owned by the specified user. Available only for admins.
     *
     * @param int $user_id      user_id of owner
     * @param string $name      new project name
     * @param array $params     description (optional) - short project description
     *                          issues_enabled (optional)
     *                          merge_requests_enabled (optional)
     *                          builds_enabled (optional)
     *                          wiki_enabled (optional)
     *                          snippets_enabled (optional)
     *                          container_registry_enabled (optional)
     *                          shared_runners_enabled (optional)
     *                          public (optional) - if true same as setting visibility_level = 20
     *                          visibility_level (optional)
     *                          import_url (optional)
     *                          public_builds (optional)
     * @return mixed
     */
    public function createForUser($user_id, $name, array $params = array())
    {
        $params['name'] = $name;

        return $this->post('projects/user/'.$this->encodePath($user_id), $params);
    }

    /**
     * Updates an existing project
     *
     * @param int $project_id   The ID of a project
     * @param array $params     name (optional) - project name
     *                          path (optional) - repository name for project
     *                          description (optional) - short project description
     *                          default_branch (optional)
     *                          issues_enabled (optional)
     *                          merge_requests_enabled (optional)
     *                          builds_enabled (optional)
     *                          wiki_enabled (optional)
     *                          snippets_enabled (optional)
     *                          container_registry_enabled (optional)
     *                          shared_runners_enabled (optional)
     *                          public (optional) - if true same as setting visibility_level = 20
     *                          visibility_level (optional)
     *                          public_builds (optional)
     * @return mixed
     */
    public function update($project_id, array $params)
    {
        return $this->put('projects/'.$this->encodePath($project_id), $params);
    }

    /**
     * Removes a project including all associated resources (issues, merge requests etc.)
     *
     * @param int $project_id       The ID of a project
     * @return mixed
     */
    public function remove($project_id)
    {
        return $this->delete('projects/'.$this->encodePath($project_id));
    }

    /**
     * Get a list of builds in a project (http://docs.gitlab.com/ce/api/builds.html#list-project-builds)
     *
     * @param int $project_id       The ID of a project
     * @param array $scope          The scope of builds to show, one or array of: pending, running, failed, success, canceled; showing all builds if none provided
     * @return mixed
     */
    public function builds($project_id, $scope = null)
    {
        return $this->get($this->getProjectPath($project_id, 'builds'), array(
            'scope' => $scope
        ));
    }

    /**
     * Get a single build of a project (http://docs.gitlab.com/ce/api/builds.html#get-a-single-build)
     *
     * @param $project_id           The ID of a project
     * @param $build_id             The ID of a build
     * @return mixed
     */
    public function build($project_id, $build_id)
    {
        return $this->get($this->getProjectPath($project_id, 'builds/'.$this->encodePath($build_id)));
    }

    /**
     * Get a trace of a specific build of a project (http://docs.gitlab.com/ce/api/builds.html#get-a-trace-file)
     *
     * @param $project_id           The ID of a project
     * @param $build_id             The ID of a build
     * @return mixed
     */
    public function trace($project_id, $build_id)
    {
        return $this->get($this->getProjectPath($project_id, 'builds/'.$this->encodePath($build_id).'/trace'));
    }

    /**
     * Get a list of a project's team members.
     *
     * @param int $project_id           The ID or NAMESPACE/PROJECT_NAME of a project
     * @param string $username_query    Query string to search for members
     * @return mixed
     */
    public function members($project_id, $username_query = null)
    {
        return $this->get($this->getProjectPath($project_id, 'members'), array(
            'query' => $username_query
        ));
    }

    /**
     * Gets a project team member.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param int $user_id          The ID of a user
     * @return mixed
     */
    public function member($project_id, $user_id)
    {
        return $this->get($this->getProjectPath($project_id, 'members/'.$this->encodePath($user_id)));
    }

    /**
     * Adds a user to a project team. This is an idempotent method and can be called multiple times with the same parameters.
     * Adding team membership to a user that is already a member does not affect the existing membership.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param int $user_id          The ID of a user to add
     * @param int $access_level     Project access level
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
     * Updates a project team member to a specified access level.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param int $user_id          The ID of a team member
     * @param int $access_level     Project access level
     * @return mixed
     */
    public function saveMember($project_id, $user_id, $access_level)
    {
        return $this->put($this->getProjectPath($project_id, 'members/'.urldecode($user_id)), array(
            'access_level' => $access_level
        ));
    }

    /**
     * Removes a user from a project team.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param int $user_id          The ID of a team member
     * @return mixed                It returns a status code 403 if the member does not have the proper rights to perform this action.
     *                              In all other cases this method is idempotent and revoking team membership for a user who is not currently a team member is considered success.
     *                              Please note that the returned JSON currently differs slightly. Thus you should not rely on the returned JSON structure.
     */
    public function removeMember($project_id, $user_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'members/'.urldecode($user_id)));
    }

    /**
     * Get a list of project hooks.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
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
     * Get a specific hook for a project.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param int $hook_id          The ID of a project hook
     * @return mixed
     */
    public function hook($project_id, $hook_id)
    {
        return $this->get($this->getProjectPath($project_id, 'hooks/'.$this->encodePath($hook_id)));
    }

    /**
     * Adds a hook to a specified project.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param string $url           The hook URL
     * @param array $params         push_events - Trigger hook on push events
     *                              issues_events - Trigger hook on issues events
     *                              merge_requests_events - Trigger hook on merge_requests events
     *                              tag_push_events - Trigger hook on push_tag events
     *                              note_events - Trigger hook on note events
     *                              enable_ssl_verification - Do SSL verification when triggering the hook
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
     * Edits a hook for a specified project.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param int $hook_id          The ID of a project hook
     * @param array $params         url (required) - The hook URL
     *                              push_events - Trigger hook on push events
     *                              issues_events - Trigger hook on issues events
     *                              merge_requests_events - Trigger hook on merge_requests events
     *                              tag_push_events - Trigger hook on push_tag events
     *                              note_events - Trigger hook on note events
     *                              enable_ssl_verification - Do SSL verification when triggering the hook
     * @return mixed
     */
    public function updateHook($project_id, $hook_id, array $params)
    {
        return $this->put($this->getProjectPath($project_id, 'hooks/'.$this->encodePath($hook_id)), $params);
    }

    /**
     * Removes a hook from a project. This is an idempotent method and can be called multiple times. Either the hook is available or not.
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
     * @param int $hook_id          The ID of hook to delete
     * @return mixed                Note the JSON response differs if the hook is available or not.
     *                              If the project hook is available before it is returned in the JSON response or an empty response is returned.
     */
    public function removeHook($project_id, $hook_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'hooks/'.$this->encodePath($hook_id)));
    }

    /**
     * Get a list of a project's deploy keys (http://docs.gitlab.com/ce/api/deploy_keys.html#list-deploy-keys)
     *
     * @param int $project_id       The ID of the project
     * @return mixed
     */
    public function keys($project_id)
    {
        return $this->get($this->getProjectPath($project_id, 'keys'));
    }

    /**
     * Get a single key (http://docs.gitlab.com/ce/api/deploy_keys.html#single-deploy-key)
     *
     * @param int $project_id       The ID of the project
     * @param int $key_id           The ID of the deploy key
     * @return mixed
     */
    public function key($project_id, $key_id)
    {
        return $this->get($this->getProjectPath($project_id, 'keys/'.$this->encodePath($key_id)));
    }

    /**
     * Creates a new deploy key for a project (http://docs.gitlab.com/ce/api/deploy_keys.html#add-deploy-key)
     * If the deploy key already exists in another project, it will be joined to current project only if original one was is accessible by the same user.
     *
     * @param int $project_id       The ID of the project
     * @param string $title         New deploy key's title
     * @param string $key           New deploy key
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
     * Delete a deploy key from a project (http://docs.gitlab.com/ce/api/deploy_keys.html#delete-deploy-key)
     *
     * @param int $project_id       The ID of the project
     * @param int $key_id           The ID of the deploy key
     * @return mixed
     */
    public function removeKey($project_id, $key_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'keys/'.$this->encodePath($key_id)));
    }

    /**
     * Get the events for the specified project. Sorted from newest to latest
     *
     * @param int $project_id       The ID or NAMESPACE/PROJECT_NAME of a project
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
     * Get all labels for a given project (http://docs.gitlab.com/ce/api/labels.html#list-labels)
     *
     * @param int $project_id       The ID of the project
     * @return mixed
     */
    public function labels($project_id)
    {
        return $this->get($this->getProjectPath($project_id, 'labels'));
    }

    /**
     * Creates a new label for the given repository with the given name and color (http://docs.gitlab.com/ce/api/labels.html#create-a-new-label)
     *
     * @param int $project_id       The ID of the project
     * @param array $params         name (string, required) - The name of the label
     *                              color (string, required) - The color of the label in 6-digit hex notation with leading # sign
     *                              description	(string, optional) - The description of the label
     * @return mixed                It returns 200 if the label was successfully created, 400 for wrong parameters and 409 if the label already exists.
     */
    public function addLabel($project_id, array $params)
    {
        return $this->post($this->getProjectPath($project_id, 'labels'), $params);
    }

    /**
     * Updates an existing label with new name or new color (http://docs.gitlab.com/ce/api/labels.html#edit-an-existing-label)
     * At least one parameter is required, to update the label.
     *
     * @param int $project_id       The ID of the project
     * @param array $params         name (string, required) - The name of the existing label
     *                              new_name (string, required if color if not provided) - The new name of the label
     *                              color (string, required if new_name is not provided) - The new color of the label in 6-digit hex notation with leading # sign
     *                              description	(string, optional) - The new description of the label
     * @return mixed                It returns 200 if the label was successfully deleted, 400 for wrong parameters and 404 if the label does not exist.
     *                              In case of an error, an additional error message is returned.
     */
    public function updateLabel($project_id, array $params)
    {
        return $this->put($this->getProjectPath($project_id, 'labels'), $params);
    }

    /**
     * Deletes a label with a given name (http://docs.gitlab.com/ce/api/labels.html#delete-a-label)
     *
     * @param int $project_id       The ID of the project
     * @param string $name          The name of the label
     * @return mixed                It returns 200 if the label was successfully deleted, 400 for wrong parameters and 404 if the label does not exist.
     *                              In case of an error, an additional error message is returned.
     */
    public function removeLabel($project_id, $name)
    {
        return $this->delete($this->getProjectPath($project_id, 'labels'), array(
            'name' => $name
        ));
    }

    /**
     * Allows modification of the forked relationship between existing projects. Available only for admins.
     * Create a forked from/to relation between existing projects.
     *
     * @param int $project_id           The ID of the project
     * @param int $forked_project_id    The ID of the project that was forked from
     * @return mixed
     */
    public function createForkRelation($project_id, $forked_project_id)
    {
        return $this->post($this->getProjectPath($project_id, 'fork/'.$this->encodePath($forked_project_id)));
    }

    /**
     * Allows modification of the forked relationship between existing projects. Available only for admins.
     * Delete an existing forked from relationship.
     *
     * @param int $project_id           The ID of the project
     * @return mixed
     */
    public function removeForkRelation($project_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'fork'));
    }

    /**
     * Sets a service for the project (http://docs.gitlab.com/ce/api/services.html)
     *
     * @param int $project_id            The ID of the project
     * @param string $service_name       The name of the service (Asana, JIRA, Redmine, etc...)
     * @param array $params              Service specific parameters (api_key, token, subdomain, etc...)
     * @return mixed
     */
    public function setService($project_id, $service_name, array $params = array())
    {
        return $this->put($this->getProjectPath($project_id, 'services/'.$this->encodePath($service_name)), $params);
    }

    /**
     * Deletes a service for the project (http://docs.gitlab.com/ce/api/services.html)
     *
     * @param int $project_id           The ID of the project
     * @param string $service_name      The name of the service (Asana, JIRA, Redmine, etc...)
     * @return mixed
     */
    public function removeService($project_id, $service_name)
    {
        return $this->delete($this->getProjectPath($project_id, 'services/'.$this->encodePath($service_name)));
    }

    /**
     * Adds or updates a build status of a commit (http://docs.gitlab.com/ce/api/commits.html#post-the-build-status-to-a-commit)
     *
     * @param $project_id       The ID of a project
     * @param $sha              The commit SHA
     * @param $state            The state of the status. Can be one of the following: pending, running, success, failed, canceled
     * @param array $params     name or context (string, optional) - The label to differentiate this status from the status of other systems. Default value is default
     *                          target_url (string, optional) - The target URL to associate with this status
     *                          description (string, optional) - The short description of the status
     * @return mixed
     */
    public function createStatus($project_id, $sha, $state, array $params = array())
    {
        $params['state'] = $state;
        return $this->post($this->getProjectPath($project_id, 'statuses/'.$this->encodePath($sha)), $params);
    }

    /**
     * Forks a project into the user namespace of the authenticated user.
     *
     * @param $project_id       The ID of the project to be forked
     * @return mixed
     */
    public function fork($project_id)
    {
        return $this->post('projects/fork/'.$this->encodePath($project_id));
    }

    /**
     * Stars a given project.
     *
     * @param $project_id       The ID of the project
     * @return mixed            Returns status code 201 and the project on success and 304 if the project is already starred.
     */
    public function star($project_id)
    {
        return $this->post($this->getProjectPath($project_id, 'star'));
    }

    /**
     * Unstars a given project.
     *
     * @param $project_id       The ID of the project
     * @return mixed            Returns status code 200 and the project on success and 304 if the project is not starred.
     */
    public function unstar($project_id)
    {
        return $this->delete($this->getProjectPath($project_id, 'star'));
    }

    /**
     * Archives the project if the user is either admin or the project owner of this project.
     * This action is idempotent, thus archiving an already archived project will not change the project.
     *
     * @param $project_id       The ID of the project
     * @return mixed            Status code 201 with the project as body is given when successful, in case the user doesn't have the proper access rights, code 403 is returned.
     *                          Status 404 is returned if the project doesn't exist, or is hidden to the user.
     */
    public function archive($project_id)
    {
        return $this->post($this->getProjectPath($project_id, 'archive'));
    }

    /**
     * Unarchives the project if the user is either admin or the project owner of this project.
     * This action is idempotent, thus unarchiving an non-archived project will not change the project.
     *
     * @param $project_id       The ID of the project
     * @return mixed            Status code 201 with the project as body is given when successful, in case the user doesn't have the proper access rights, code 403 is returned.
     *                          Status 404 is returned if the project doesn't exist, or is hidden to the user.
     */
    public function unarchive($project_id)
    {
        return $this->post($this->getProjectPath($project_id, 'unarchive'));
    }

    /**
     * Uploads a file to the specified project to be used in an issue or merge request description, or a comment.
     *
     * @param $project_id       The ID of the project
     * @param $file             The file to be uploaded
     *                          {
     *                              "alt": "dk",
     *                              "url": "/uploads/66dbcd21ec5d24ed6ea225176098d52b/dk.png",
     *                              "is_image": true,
     *                              "markdown": "![dk](/uploads/66dbcd21ec5d24ed6ea225176098d52b/dk.png)"
     *                          }
     *
     * @return mixed             The returned url is relative to the project path. In Markdown contexts, the link is automatically expanded when the format in markdown is used.
     */
    public function upload($project_id, $file)
    {
        return $this->post($this->getProjectPath($project_id, 'uploads'), array(
            'file' => $file
        ));
    }

    /**
     * Allow to share project with group.
     *
     * @param $project_id       The ID of a project
     * @param $group_id         The ID of a group
     * @param $group_access     Level of permissions for sharing
     *
     * @return mixed
     */
    public function share($project_id, $group_id, $group_access)
    {
        return $this->post($this->getProjectPath($project_id, 'share'), array(
            'group_id' => $group_id,
            'group_access' => $group_access
        ));
    }


}
