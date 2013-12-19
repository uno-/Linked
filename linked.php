class List_Node {
	function __construct($data) {
		$this->id = key($data);
		$this->data = $data[$this->id];
		$this->ln_Succ = NULL; 
		$this->ln_Pred = NULL;
	}
}

class Linked_List {
	private $length = 0;
	
	function __construct() {$this->new_list();}

	function size() {return $this->length;}
	
	function is_first(&$node) {return ($node === $this->lh_Head) ? TRUE:FALSE;}
	
	function is_last(&$node) {return ($node === $this->lh_Tail) ? TRUE:FALSE;}
	
	function is_empty() {return ($this->lh_Head === $this->lh_TailPred) ? TRUE:FALSE;}
	
	function has_node(&$node) {
		$list_node = $this->lh_Head;
		
		while ($list_node) {
			if ($list_node->id === $node->id) return TRUE ;
			$list_node = $list_node->ln_Pred;
		}
		return FALSE;
	}
	
	function get_node($id) {
		$node = $this->lh_Head;
		
		while ($node) {
			if ($node->id === $id) return $node;
			$node = $node->ln_Pred;
		}
		return FALSE;
	}
	
	function new_list() {
		$this->lh_Head = $this->lh_TailPred;
		$this->lh_Tail = $this->lh_TailPred ;
		$this->lh_TailPred = NULL;
	}
	
	function add_head(&$node) {
		if ($this->is_empty()) { 
			$this->lh_Head = $node;
			$this->lh_Tail = $node;
			$node->ln_Succ = $this->lh_TailPred;
			$node->ln_Pred = $this->lh_TailPred;
		} else {
			$node->ln_Pred = $this->lh_Head;
			$this->lh_Head = $node;
			$node->ln_Pred->ln_Succ = $node;
		}
		$this->length++;
	}
	
	function add_tail(&$node) {
		if ($this->is_empty()) { 
			$this->lh_Head = $node;
			$this->lh_Tail = $node;
			$node->ln_Succ = $this->lh_TailPred;
			$node->ln_Pred = $this->lh_TailPred;
		}  else {
			$node->ln_Succ = $this->lh_Tail;
			$this->lh_Tail = $node;
			$node->ln_Succ->ln_Pred = $node;
			$node->ln_Pred = $this->lh_TailPred;
		}
		$this->length++;
	}
	
	function after(&$node1, &$node2) {
		if (!$this->has_node($node2) || $node1 === $node2) return FALSE;
		
		if ($this->is_last($node2)) {
			$node1->ln_Succ = $this->lh_Tail;
			$this->lh_Tail = $node1;
			$node1->ln_Succ->ln_Pred = $node1;
			$node1->ln_Pred = $this->lh_TailPred;
		} else {
			$node1->ln_Pred = $node2->ln_Pred; 
			$node1->ln_Pred->ln_Succ = $node1; 
			$node1->ln_Succ = $node2;
			$node2->ln_Pred = $node1;
			$this->length++;
		}
		$this->length++;
		return TRUE;
	}
	
	function before(&$node1, &$node2) {
		if (!$this->has_node($node2) || $node1 === $node2) return FALSE;
		
		if ($this->is_first($node2)) {
			$node1->ln_Pred = $node2;
			$node2->ln_Succ = $node1;
			$node1->ln_Succ = $this->lh_TailPred;
			$this->lh_Head = $node1;
		} else {
			$node1->ln_Succ = $node2->ln_Succ;
			$node1->ln_Succ->ln_Pred = $node1; 
			$node1->ln_Pred = $node2;
			$node2->ln_Succ = $node1;
		}
		$this->length++;
		return TRUE;
	}
	
	function replace(&$node1, &$node2) {
		if (!$this->has_node($node1) || $node1 === $node2) return FALSE;
		
		if ($this->has_node($node2)) $this->remove($node2);
		
		if ($this->is_first($node1)) {
			$node2->ln_Succ = $this->lh_TailPred;
			$node1->ln_Pred->ln_Succ = $node2;
			$node2->ln_Pred = $node1->ln_Pred;
			$this->lh_Head = $node2;
		} else if ($this->is_last($node1)) {
			$node2->ln_Succ = $this->lh_Tail->ln_Succ;
			$node1->ln_Succ->ln_Pred = $node2;
			$node2->ln_Pred = $this->lh_TailPred;
			$this->lh_Tail = $node2;
		} else {
			$node2->ln_Succ = $node1->ln_Succ;
			$node2->ln_Pred = $node1->ln_Pred;
			$node1->ln_Succ->ln_Pred = $node2;
			$node1->ln_Pred->ln_Succ = $node2;
		}
		return TRUE;
	}
	
	function swap(&$node1, &$node2) {
		if (!$this->has_node($node1) || !$this->has_node($node2) || $node1 === $node2) return FALSE;
	
		if (($this->is_first($node1) && $this->is_last($node2)) || ($this->is_first($node2) && $this->is_last($node1))) {
			if ($this->is_first($node1)) {
				$first_node = $node1;
				$second_node = $node2;
			} else {
				$first_node = $node2;
				$second_node = $node1;
			}
			
			$ln_Pred = $first_node->ln_Pred;
			$first_node->ln_Succ = $second_node->ln_Succ;
			$first_node->ln_Pred = $this->lh_TailPred;
			$first_node->ln_Succ->ln_Pred = $first_node;
				
			$second_node->ln_Succ = $this->lh_TailPred;
			$second_node->ln_Pred = $ln_Pred;
			$second_node->ln_Pred->ln_Succ = $second_node;
				
			$this->lh_Head = $second_node;
			$this->lh_Tail = $first_node;
		} else if ($this->is_first($node1) || $this->is_first($node2)) { 
			if ($this->is_first($node1)) {
				$first_node = $node1;
				$second_node = $node2;
			} else {
				$first_node = $node2;
				$second_node = $node1;
			}
			$ln_Pred = $first_node->ln_Pred;
			
			$first_node->ln_Succ = $second_node->ln_Succ;
			$first_node->ln_Pred = $second_node->ln_Pred;
			$first_node->ln_Pred->ln_Succ = $first_node;
			$first_node->ln_Succ->ln_Pred = $first_node;
			
			$second_node->ln_Succ = $this->lh_TailPred;
			$second_node->ln_Pred = $ln_Pred;
			$second_node->ln_Pred->ln_Succ = $second_node;
			
			$this->lh_Head = $second_node;
		} else if ($this->is_last($node1) || $this->is_last($node2)) {
			if ($this->is_last($node2)) {
				$first_node = $node1;
				$second_node = $node2;
			} else {
				$first_node = $node2;
				$second_node = $node1;
			}
			$ln_Succ = $first_node->ln_Succ;
			$ln_Pred = $first_node->ln_Pred;
			
			$first_node->ln_Succ = $second_node->ln_Succ;
			$first_node->ln_Pred = $second_node->ln_Pred;
			$first_node->ln_Succ->ln_Pred = $first_node;
			
			$second_node->ln_Succ = $ln_Succ;
			$second_node->ln_Pred = $ln_Pred;
			$second_node->ln_Succ->ln_Pred = $second_node;
			$second_node->ln_Pred->ln_Succ = $second_node;
			
			$this->lh_Tail = $first_node;
		} else {
			$ln_Succ = $node1->ln_Succ;
			$ln_Pred = $node1->ln_Pred;
			
			$node1->ln_Succ = $node2->ln_Succ;
			$node1->ln_Pred = $node2->ln_Pred;
			$node1->ln_Succ->ln_Pred = $node1;
			$node1->ln_Pred->ln_Succ = $node1;
			
			$node2->ln_Succ = $ln_Succ;
			$node2->ln_Pred = $ln_Pred;
			$node2->ln_Succ->ln_Pred = $node2;
			$node2->ln_Pred->ln_Succ = $node2;
		}
	}
	
	function remove(&$node) {
		if (!$this->has_node($node)) return FALSE;
		
		if ($this->is_first($node)) {
			$this->lh_Head = $this->lh_Head->ln_Pred;
			$this->lh_Head->ln_Succ = $this->lh_TailPred;
		} else if ($this->is_last($node)) {
			$this->lh_Tail = $this->lh_Tail->ln_Succ;
			$this->lh_Tail->ln_Pred = $this->lh_TailPred;
		} else {
			$node->ln_Succ->ln_Pred = $node->ln_Pred;
			$node->ln_Pred->ln_Succ = $node->ln_Succ;
			
		}
		$this->length--;
		
		return TRUE;
	}
	
	function walk($echo=TRUE) {
		$node = $this->lh_Head;
		
		$cnt = 0;
		$html = '
				List Size '.$this->size().'<br/>
				List Head Node ID: '.(($this->lh_Head->id !== NULL) ? $this->lh_Head->id:'NULL').'<br/>
				List Tail Node ID: '.(($this->lh_Tail->id !== NULL) ? $this->lh_Tail->id:'NULL').'<br/>
				List TailPred: '.(($this->lh_TailPred) ? $this->lh_TailPred->id:'NULL') . '<br/><br/><br/>';
		while ($node) {
			
			$html .= '
				Node#: '.($cnt++).'<br/>
				Node ID: '.$node->id.'<br>
				Node Succ ID: '.(($node->ln_Succ->id !== NULL) ? $node->ln_Succ->id:'NULL').'<br/>
				Node Pred ID: '.(($node->ln_Pred->id !== NULL) ? $node->ln_Pred->id:'NULL').'<br/>
				Node Data: '.$this->dump($node->data, FALSE);
				
			$node = $node->ln_Pred;
		
		}
		if ($echo) echo $html; else return $html; 
	}
	
	function dump($var, $echo=TRUE) {
		ob_start();
		echo ('<pre>');
		print_r($var);
		echo('</pre>');
		$html = ob_get_contents();
		ob_end_clean();
		
		if ($echo) echo $html; else return $html; 
	}
}
