<?php
/**
 * YQuery
 *
 * Simple query builder for php.
 * @author  Yeri <arifyeripratama@gmail.com>
 * @link 	https://github.com/yeripratama/YQuery
 */
class YQuery
{	
	/**
	 * The query string
	 * @var string
	 */
	public $query = "";
	/**
	 * The string to be appended
	 * @var string
	 */
	public $string = "";
	/**
	 * Stores the selected fields
	 * @var array
	 */
	public $select = array();
	/**
	 * Stores parts of FROM clause
	 * @var array
	 */
	public $from = array();
	/**
	 * Stores parts of WHERE .. AND clause
	 * @var array
	 */
	public $andWhere = array();
	/**
	 * Stores parts of WHERE .. OR clause
	 * @var array
	 */
	public $orWhere = array();
	/**
	 * Stores parts of GROUP BY clause
	 * @var array
	 */
	public $groupBy = array();
	/**
	 * Stores parts of HAVING .. AND clause
	 * @var array
	 */
	public $having = array();
	/**
	 * Stores parts of HAVING .. OR clause
	 * @var array
	 */
	public $orHaving = array();
	/**
	 * Stores parts of ORDER BY clause
	 * @var array
	 */
	public $orderBy = array();
	/**
	 * Add fields to SELECT clause
	 * @param  string $string parts of SELECT clause (the fields)
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function select($string, $ref = '')
	{
		if ($ref === ''){
			$this->select[] = $string;
		} else {
			$this->select[$ref] = $string;
		}

		return $this;
	}
	/**
	 * Add tables
	 * @param  string $string table names
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function from($string, $ref = '')
	{
		if ($ref === ''){
			$this->from[] = $string;
		} else {
			$this->from[$ref] = $string;
		}
		return $this;
	}
	/**
	 * Add WHERE .. AND conditions
	 * @param  string $string WHERE .. AND conditions, or just a single WHERE condition
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function andWhere($string, $ref = '')
	{
		if ($ref === ''){
			$this->andWhere[] = $string;
		} else {
			$this->andWhere[$ref] = $string;
		}
		return $this;
	}
	/**
	 * Add WHERE .. OR conditions
	 * @param  string $string the WHERE .. OR conditions, or just a single WHERE condition
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function orWhere($string, $ref = '')
	{
		if ($ref === ''){
			$this->orWhere[] = $string;
		} else {
			$this->orWhere[$ref] = $string;
		}
		return $this;
	}
	/**
	 * Add HAVING conditions
	 * @param  string $string the HAVING .. AND conditions, or just a single HAVING condition
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function having($string, $ref = '')
	{
		if ($ref === ''){
			$this->having[] = $string;
		} else {
			$this->having[$ref] = $string;
		}
		return $this;
	}
	/**
	 * Add HAVING .. OR conditions
	 * @param  string $string the HAVING .. OR conditions, or just a single HAVING condition
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function orHaving($string, $ref = '')
	{
		if ($ref === ''){
			$this->orHaving[] = $string;
		} else {
			$this->orHaving[$ref] = $string;
		}
		return $this;
	}
	/**
	 * Add GROUP BY conditions
	 * @param  string $string the GROUP BYs conditions, or just a single GROUP BY condition
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function groupBy($string, $ref = '')
	{
		if ($ref === ''){
			$this->groupBy[] = $string;
		} else {
			$this->groupBy[$ref] = $string;
		}
		return $this;
	}
	/**
	 * Add orders
	 * @param  string $string the ORDER BY portions
	 * @param  string $ref    a name to this portion of query, so we can call it later by reference
	 * @return YQuery         [description]
	 */
	public function orderBy($string, $ref = '')
	{
		if ($ref === ''){
			$this->orderBy[] = $string;
		} else {
			$this->orderBy[$ref] = $string;
		}
		return $this;
	}

	/**
	 * Build the SELECT query
	 * @return string The query
	 */
	public function getQuery()
	{
		// SELECT and FROM clause
		$this->query = "SELECT " . implode(',', $this->select) . " FROM " . implode($this->from);
		
		// AND WHERE clause
		if (!empty($this->andWhere)) {
			$this->query .= " WHERE ";
			if (count($this->andWhere) > 1) {
				$this->query .= implode(' AND ', $this->andWhere);
			} else {
				$this->query .= implode('', $this->andWhere);
			}
		}

		// OR WHERE clause
		if (!empty($this->orWhere)) {
			// check whether there is the 'WHERE' word
			if (strpos($this->query, "WHERE") === false || empty($this->andWhere)) {
				$this->query .= " WHERE ";
			} else {
				$this->query .= " AND ";
			}

			if (count($this->orWhere) > 1) {
				$this->query .= " ( ";
				$this->query .= implode(' OR ', $this->orWhere);
				$this->query .= " ) ";
			} else {
				$this->query .= implode('', $this->orWhere);
			}
		}

		// GROUP BY clause
		if (!empty($this->groupBy)) {
			$this->query .= " GROUP BY ";
			if (count($this->groupBy) > 1) {
				$this->query .= implode(',', $this->groupBy);
			} else {
				$this->query .= implode('', $this->groupBy);
			}
		}

		// HAVING clause
		if (!empty($this->having)) {
			$this->query .= " HAVING ";
			if (count($this->having) > 1) {
				$this->query .= implode(' AND ', $this->having);
			} else {
				$this->query .= implode('', $this->having);
			}
		}

		// HAVING OR clause
		if (!empty($this->orHaving)) {
			if (strpos($this->query, "HAVING") === false || empty($this->having)) {
				$this->query .= " HAVING ";
			} else {
				$this->query .= " OR ";
			}

			if (count($this->orHaving) > 1) {
				$this->query .= implode(' OR ', $this->orHaving);
			} else {
				$this->query .= implode('', $this->orHaving);
			}
		}

		// ORDER BY clause
		if (!empty($this->orderBy)) {
			$this->query .= " ORDER BY ";
			if (count($this->orderBy) > 1) {
				$this->query .= implode(',', $this->orderBy);
			} else {
				$this->query .= implode('', $this->orderBy);
			}
		}

		return $this->query;
	}
	/**
	 * Reset all the object property to their respective default value
	 * @return [type] [description]
	 */
	public function reset()
	{
		foreach (get_class_vars(get_class($this)) as $name => $default) 
		  $this->$name = $default;
	}
	/**
	 * Delete a portion of query by clause and reference
	 * @param  string $clause a clause
	 * @param  string $ref    a name of a portions of the query
	 * @return YQuery         [description]
	 */
	public function remove($clause, $ref)
	{
		unset($this->{$clause}[$ref]);
		return $this;
	}
}