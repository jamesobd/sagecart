<?php

class _Resource__Model extends CI_Model {

    var $CI;

    function __construct() {
        parent::__construct();

        $this->CI =& get_instance();
    }


    /*
    |--------------------------------------------------------------------------
    | _Resource_ CRUD methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create _resource_
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        $this->db->insert('_resource_', $data);
        $data['id'] = $this->db->insert_id();
        return $data;
    }

    /**
     * Get all _resource_s
     *
     * @param array $where - optional where clauses for doing filtering
     * @return mixed
     */
    public function getAll($where = array()) {
        return $this->db->get_where('_resource_', $where)->result();
    }

    /**
     * Get _resource_
     *
     * @param int $_resource__id
     * @return mixed
     */
    public function get($_resource__id) {
        return $this->db->get_where('_resource_', array('_resource_.id' => $_resource__id))->row();
    }

    /**
     * Update _resource_
     *
     * @param int   $_resource__id
     * @param array $data
     * @return bool
     */
    public function update($_resource__id, array $data) {
        $this->db->where('id', $_resource__id)
            ->update('_resource_', $data);
    }

    /**
     * Delete _resource_
     *
     * @param int $_resource__id
     * @return bool
     */
    public function delete($_resource__id) {
        $this->db->where('_resource_.id', $_resource__id)
            ->delete('_resource_');
    }

    /*
    |--------------------------------------------------------------------------
    | _Resource_ methods by _parent_ relation.
    |--------------------------------------------------------------------------
    */

    /**
     * Create _resource_ by _parent_
     *
     * @param int   $_parent__id
     * @param array $data
     * @return mixed
     */
    public function createBy_Parent_($_parent__id, $data = array()) {
        $data['_parent__id'] = $_parent__id;
        $this->db->insert('_resource_', $data);
        $data['id'] = $this->db->insert_id();
        return $data;
    }

    /**
     * Get all _resource_s by _parent_
     *
     * @param int   $_parent__id
     * @param array $where - optional where clauses for doing filtering
     * @return mixed
     */
    public function getAllBy_Parent_($_parent__id, $where = array()) {
        return $this->db->select('_resource_.*')
            ->from('_resource_')
            ->join('_parent_', '_parent_.id = _resource_._parent__id')
            ->where('_parent_.id', $_parent__id)
            ->where($where)
            ->get()->result();
    }

    /**
     * Get _resource_ by _parent_
     *
     * @param int $_parent__id
     * @param int $_resource__id
     * @return mixed
     */
    public function getBy_Parent_($_parent__id, $_resource__id) {
        return $this->db->select('_resource_.*')
            ->from('_resource_')
            ->join('_parent_', '_parent_.id = _resource_._parent__id')
            ->where('_parent_.id', $_parent__id)
            ->where('_resource_.id', $_resource__id)
            ->get()->row();
    }

    /**
     * Update _resource_ by _parent_
     *
     * @param int   $_parent__id
     * @param int   $_resource__id
     * @param array $data
     * @return bool
     */
    public function updateBy_Parent_($_parent__id, $_resource__id, $data = array()) {
        $this->db->where('_parent_.id', $_parent__id)
            ->where('_resource_.id', $_resource__id)
            ->update('_resource_ JOIN _parent_ ON _parent_.id = _resource_._parent__id', $data);
    }

    /**
     * Delete _resource_ by _parent_
     *
     * @param int $_parent__id
     * @param int $_resource__id
     * @return bool
     */
    public function deleteBy_Parent_($_parent__id, $_resource__id) {
        $this->db->where('_parent_.id', $_parent__id)
            ->where('_resource_.id', $_resource__id)
            ->delete('_resource_ JOIN _parent_ ON _parent_.id = _resource_._parent__id');
    }

    /**
     * Join _resource_ to _parent_
     *
     * @param int $_parent__id
     * @param int $_resource__id
     * @return mixed
     */
    public function addBy_Parent_($_parent__id, $_resource__id) {
        $data = array();
        $data['_parent__id'] = $_parent__id;
        $data['_resource__id'] = $_resource__id;
        $this->db->insert('_resource__link', $data);
    }

    /**
     * Returns TRUE if _resource_ by _parent_ exists
     *
     * @param int $_parent__id
     * @param int $_resource__id
     * @return bool
     */
    public function existsBy_Parent_($_parent__id, $_resource__id) {
        return $this->db->from('_resource_')
            ->join('_parent_', '_parent_.id = _resource_._parent__id')
            ->where('_parent_.id', $_parent__id)
            ->where('_resource_.id', $_resource__id)
            ->limit(1)->get()->num_rows() === 1;
    }


    /*
    |--------------------------------------------------------------------------
    | _Resource_ methods by _grandparent_ _parent_ relation.
    |--------------------------------------------------------------------------
    */

    /**
     * Create _resource_ by _grandparent_ _parent_
     *
     * @param int   $_grandparent__id
     * @param int   $_parent__id
     * @param array $data
     * @return mixed
     */
    public function createBy_Grandparent__Parent_($_grandparent__id, $_parent__id, $data = array()) {
        $data['_grandparent__id'] = $_grandparent__id;
        $data['_parent__id'] = $_parent__id;
        $this->db->insert('_resource_', $data);
        $data['id'] = $this->db->insert_id();
        return $data;
    }

    /**
     * Get all _resource_s by _grandparent_ _parent_
     *
     * @param int   $_grandparent__id
     * @param int   $_parent__id
     * @param array $where - optional where clauses for doing filtering
     * @return mixed
     */
    public function getAllBy_Grandparent__Parent_($_grandparent__id, $_parent__id, $where = array()) {
        return $this->db->select('_resource_.*')
            ->from('_resource_')
            ->join('_parent_', '_parent_.id = _resource_._parent__id')
            ->join('_grandparent_', '_grandparent_.id = _parent_._grandparent__id')
            ->where('_parent_.id', $_parent__id)
            ->where('_grandparent_.id', $_grandparent__id)
            ->where($where)
            ->get()->result();
    }

    /**
     * Get _resource_ by _grandparent_ _parent_
     *
     * @param int $_grandparent__id
     * @param int $_parent__id
     * @param int $_resource__id
     * @return mixed
     */
    public function getBy_Grandparent__Parent_($_grandparent__id, $_parent__id, $_resource__id) {
        return $this->db->select('_resource_.*')
            ->from('_resource_')
            ->join('_parent_', '_parent_.id = _resource_._parent__id')
            ->join('_grandparent_', '_grandparent_.id = _parent_._grandparent__id')
            ->where('_resource_.id', $_resource__id)
            ->where('_parent_.id', $_parent__id)
            ->where('_grandparent_.id', $_grandparent__id)
            ->get()->row();
    }

    /**
     * Update _resource_ by _grandparent_ _parent_
     *
     * @param int   $_grandparent__id
     * @param int   $_parent__id
     * @param int   $_resource__id
     * @param array $data
     * @return bool
     */
    public function updateBy_Grandparent__Parent_($_grandparent__id, $_parent__id, $_resource__id, $data = array()) {
        $this->db->where('_grandparent_.id', $_grandparent__id)
            ->where('_parent_.id', $_parent__id)
            ->where('_resource_.id', $_resource__id)
            ->update('_resource_ JOIN _parent_ ON _parent_.id = _resource_._parent__id JOIN _grandparent_ ON _grandparent_.id = _parent_._grandparent__id', $data);
    }

    /**
     * Delete _resource_ by _grandparent_ _parent_
     *
     * @param int $_grandparent__id
     * @param int $_parent__id
     * @param int $_resource__id
     * @return bool
     */
    public function deleteBy_Grandparent__Parent_($_grandparent__id, $_parent__id, $_resource__id) {
        $this->db->where('_resource_.id', $_resource__id)
            ->where('_parent_.id', $_parent__id)
            ->where('_grandparent_.id', $_grandparent__id)
            ->delete('_resource_ JOIN _parent_ ON _parent_.id = _resource_._parent__id JOIN _grandparent_ ON _grandparent_.id = _parent_._grandparent__id');
    }

    /**
     * Returns TRUE if _resource_ by _grandparent_ _parent_ exists
     *
     * @param int $_grandparent__id
     * @param int $_parent__id
     * @param int $_resource__id
     * @return bool
     */
    public function existsBy_Grandparent__Parent_($_grandparent__id, $_parent__id, $_resource__id) {
        return $this->db->from('_resource_')
            ->join('_parent_', '_parent_.id = _resource_._parent__id')
            ->join('_grandparent_', '_grandparent_.id = _parent_._grandparent__id')
            ->where('_resource_.id', $_resource__id)
            ->where('_parent_.id', $_parent__id)
            ->where('_grandparent_.id', $_grandparent__id)
            ->limit(1)->get()->num_rows() === 1;
    }
}