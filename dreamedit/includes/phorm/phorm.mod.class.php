<?

include_once dirname(__FILE__)."/phorm.class.php";

class mod_phorm extends phorm {

	function mod_phorm ($mod_array = array()) {
		$this->phorm = $mod_array;
		$this->mod_phorm_values();
	}

	function mod_phorm_values($values = array()) {
		$this->phorm($values);
	}

}
?>