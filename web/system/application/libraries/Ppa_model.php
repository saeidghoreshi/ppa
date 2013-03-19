<?php

/**
 * Generic base model for all model classes within PPA. Provides all data access
 * to the a given DB table as specified by $table.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */

class Ppa_model extends Model
{

    /**
     * @author
     * @version 0.1
     */

    protected $table = '';
    protected $id_column_name = '';

    protected function __construct($table)
    {
        parent::Model();
        $this->table = (string) $table;
        $this->id_column_name = $this->table . '_id';
	$this->cismarty->assign('config', $this->config->config);
    }

    /**
     * Insert
     *
     * @return    the last inserted id
     * @param    array
     */
    protected function insert($data = null)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Get Where
     *
     * @return    result
     * @param    array, int, int
     */
    protected function get_where($where = null, $limit = null, $offset = null)
    {
        return $this->db->get_where($this->table, $where, $limit, $offset);
    }

    /**
     * Get Where In
     *
     * @return   result
     * @param    string, array
     */
    protected function get_where_in($selected_value = '',
        $possible_values = array())
    {
        $this->db->where_in($selected_value, $possible_values);
        return $this->db->get($this->table);
    }

    /**
     * Update
     *
     * @return    void
     * @param    int, array
     */
    protected function update($id = null, $data = null, $id_column_name = null)
    {
        $this->db->where( $id_column_name?$id_column_name:$this->id_column_name, $id );
        $this->db->update($this->table, $data);
    }

    /**
     * Delete
     *
     * @return    void
     * @param    bool
     */
    protected function delete($id = null)
    {
        $this->db->where($this->id_column_name, $id);
        return $this->db->delete($this->table);
    }

    /**
     * Get all the records
     *
     * @return    result
     */
    protected function get_all()
    {
        $q = $this->db->get($this->table);
        return $q->result();
    }

    /**
     * Get one row by id
     *
     * @return    array
     * @param    int
     */
    protected function get_row_by_id($id = null)
    {
        $this->db->where($this->id_column_name, $id);
        $q = $this->db->get($this->table);
        return $q->row_array();
    }

    /**
     * Get one row by given column name and column value
     *
     * @return    array
     * @param    int
     */
    protected function get_row($column_name = null, $column_value = null)
    {
        $this->db->where($column_name, $column_value);
        $q = $this->db->get($this->table);
        return $q->row_array();
    }

    /**
     * Get one row by given column name and column value
     *
     * @return   array
     * @param    int
     */
    protected function get_rows($column_name = null, $column_value = null)
    {
        $this->db->where($column_name, $column_value);
        $q = $this->db->get($this->table);
        $rows = array();

        if ($q->num_rows() > 0)
        {
            foreach ($q->result_array() as $row)
            {
                array_push($rows, $row);
            }
        }

        return $rows;
    }

    /**
     * Run a direct SQL query against the DB and return the result
     *
     * @return   result
     * @param    string, SQL query statement to run
     * @param    array, array of parameter values to combine with SQL
     */
    protected function query($sql = null, $data = array())
    {
        return $this->db->query($sql, $data);
    }

    /**
     * Get total number of rows currently in this table
     *
     * @return    int
     */
    protected function count_all()
    {
        return (int) $this->db->count_all_results($this->table);
    }

    /**
     * Remove all records in this table
     *
     * @return    void
     */
    protected function empty_table()
    {
        $this->db->empty_table($this->table);
    }

}

/* End of file Ppa_model.php */
/* Location: ./system/application/libraries/Ppa_model.php */