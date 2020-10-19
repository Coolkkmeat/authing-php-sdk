<?php


namespace Authing;

use Exception;

require_once __DIR__ . '/CodeGen.php';

class RolesManagementClient
{
    /**
     * @var ManagementClient
     */
    private $client;

    /**
     * RolesManagementClient constructor.
     * @param $client ManagementClient
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * 获取角色列表
     *
     * @param $page int 分页页数
     * @param $limit int 分页大小
     * @return PaginatedRoles
     * @throws Exception
     */
    public function paginate($page = 1, $limit = 10)
    {
        $param = (new RolesParam())->withPage($page)->withLimit($limit);
        return $this->client->request($param->createRequest());
    }

    /**
     * 创建角色
     *
     * @param $code string 角色唯一标志
     * @param $description string 角色描述
     * @param $parentCode string 父角色唯一标志
     * @return Role
     * @throws Exception
     */
    public function create($code, $description = null, $parentCode = null)
    {
        $param = (new CreateRoleParam($code))->withDescription($description)->withParent($parentCode);
        return $this->client->request($param->createRequest());
    }

    /**
     * 获取角色信息
     *
     * @param $code string 角色唯一标志
     * @return Role
     * @throws Exception
     */
    public function detail($code)
    {
        $param = new RoleParam($code);
        return $this->client->request($param->createRequest());
    }

    /**
     * 更新角色信息
     *
     * @param $code string 角色唯一 ID
     * @param $description string 角色描述
     * @param $newCode string 新的角色唯一 ID
     * @return Role
     * @throws Exception
     */
    public function update($code, $description = null, $newCode = null)
    {
        $param = (new UpdateRoleParam($code))->withDescription($description)->withNewCode($newCode);
        return $this->client->request($param->createRequest());
    }

    /**
     * 删除角色
     *
     * @param $code string 角色唯一 ID
     * @return CommonMessage
     * @throws Exception
     */
    public function delete($code)
    {
        $param = new DeleteRoleParam($code);
        return $this->client->request($param->createRequest());
    }

    /**
     * 批量删除角色
     *
     * @param $codeList string[] 角色唯一 ID 列表
     * @return CommonMessage
     * @throws Exception
     */
    public function deleteMany($codeList)
    {
        $param = new DeleteRolesParam($codeList);
        return $this->client->request($param->createRequest());
    }

    /**
     * 批量添加用户
     *
     * @param $code string 角色唯一 ID
     * @param $userIds string[] 用户 ID 列表
     * @return CommonMessage
     * @throws Exception
     */
    public function addUsers($code, $userIds)
    {
        $param = (new AssignRoleParam())->withUserIds($userIds)->withRoleCodes([$code]);
        return $this->client->request($param->createRequest());
    }

    /**
     * 批量移除用户
     *
     * @param $code string 角色唯一 ID
     * @param $userIds string[] 用户 ID 列表
     * @return CommonMessage
     * @throws Exception
     */
    public function removeUsers($code, $userIds)
    {
        $param = (new RevokeRoleParam())->withUserIds($userIds)->withRoleCodes([$code]);
        return $this->client->request($param->createRequest());
    }

    /**
     * 获取策略列表
     *
     * @param $code string 角色唯一 ID
     * @param $page int 分页页数
     * @param $limit int 分页大小
     * @return PaginatedPolicyAssignment
     * @throws Exception
     */
    public function listPolicies($code, $page = 1, $limit = 10)
    {
        $param = (new PolicyAssignmentsParam())
            ->withPage($page)
            ->withLimit($limit)
            ->withTargetIdentifier($code)
            ->withTargetType(PolicyAssignmentTargetType::ROLE);
        return $this->client->request($param->createRequest());
    }

    /**
     * 添加策略
     *
     * @param $code string 角色唯一 ID
     * @param $policies string[] 策略 ID 列表
     * @return CommonMessage
     * @throws Exception
     */
    public function addPolicies($code, $policies)
    {
        $param = (new AddPolicyAssignmentsParam($policies, PolicyAssignmentTargetType::ROLE))
            ->withTargetIdentifiers([$code]);
        return $this->client->request($param->createRequest());
    }

    /**
     * 移除策略
     *
     * @param $code string 角色唯一 ID
     * @param $policies string[] 策略 ID 列表
     * @return CommonMessage
     * @throws Exception
     */
    public function removePolicies($code, $policies)
    {
        $param = (new RemovePolicyAssignmentsParam($policies, PolicyAssignmentTargetType::ROLE))
            ->withTargetIdentifiers([$code]);
        return $this->client->request($param->createRequest());
    }
}