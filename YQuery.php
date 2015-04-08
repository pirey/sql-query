<?php
/**
 * YQuery
 *
 * Simple query builder.
 * @author  Yeri <arifyeripratama@gmail.com>
 */
class YQuery
{	
	public $query = "";
	public $string = "";
	public $select = array();
	public $from = array();
	public $andWhere = array();
	public $orWhere = array();
	public $groupBy = array();
	public $having = array();
	public $orderBy = null;

	# insert in select clause
	public function select($string, $ref = '')
	{
		if ($ref === ''){
			$this->select[] = $string;
		} else {
			$this->select[$ref] = $string;
		}

		return $this;
	}

	public function from($string, $ref = '')
	{
		if ($ref === ''){
			$this->from[] = $string;
		} else {
			$this->from[$ref] = $string;
		}
		return $this;
	}

	public function andWhere($string, $ref = '')
	{
		if ($ref === ''){
			$this->andWhere[] = $string;
		} else {
			$this->andWhere[$ref] = $string;
		}
		return $this;
	}

	public function orWhere($string, $ref = '')
	{
		if ($ref === ''){
			$this->orWhere[] = $string;
		} else {
			$this->orWhere[$ref] = $string;
		}
		return $this;
	}

	public function having($string, $ref = '')
	{
		if ($ref === ''){
			$this->having[] = $string;
		} else {
			$this->having[$ref] = $string;
		}
		return $this;
	}

	public function groupBy($string, $ref = '')
	{
		if ($ref === ''){
			$this->groupBy[] = $string;
		} else {
			$this->groupBy[$ref] = $string;
		}
		return $this;
	}

	public function orderBy($string, $ref = '')
	{
		if ($ref === ''){
			$this->orderBy[] = $string;
		} else {
			$this->orderBy[$ref] = $string;
		}
		return $this;
	}

	# Building the query
	public function getQuery()
	{
		# SELECT and FROM clause
		$this->query = "SELECT " . implode(',', $this->select) . " FROM " . implode($this->from);
		
		# AND WHERE clause
		if (!empty($this->andWhere)) {
			$this->query .= " WHERE ";
			if (count($this->andWhere) > 1) {
				$this->query .= implode(' AND ', $this->andWhere);
			} else {
				$this->query .= array_shift($this->andWhere);
			}
		}

		# OR WHERE clause
		if (!empty($this->orWhere)) {
			# check whether there is the 'WHERE' word
			if (strpos($this->query, "WHERE") === false || empty($this->andWhere)) {
				$this->query .= " WHERE ";
			}

			if (count($this->orWhere) > 1) {
				$this->query .= implode(' OR ', $this->orWhere);
			} else {
				$this->query .= array_shift($this->orWHere);
			}
		}

		# GROUP BY clause
		if (!empty($this->groupBy)) {
			$this->query .= " GROUP BY ";
			if (count($this->groupBy) > 1) {
				$this->query .= implode(',', $this->groupBy);
			} else {
				$this->query .= array_shift($this->groupBy);
			}
		}

		# HAVING clause
		if (!empty($this->having)) {
			$this->query .= " HAVING ";
			if (count($this->having) > 1) {
				$this->query .= implode(',', $this->having);
			} else {
				$this->query .= array_shift($this->having);
			}
		}

		# ORDER BY clause
		if (!empty($this->orderBy)) {
			$this->query .= " ORDER BY " . array_shift($this->orderBy);
		}

		return $this->query;
	}

	public function remove($clause, $ref)
	{
		unset($this->{$clause}[$ref]);
	}
}
