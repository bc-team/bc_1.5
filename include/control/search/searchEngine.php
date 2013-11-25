<?php
class SearchEngine
{
	public $searchingEntities;
	public $resultsNumber=0;
	public function __construct()
	{

		foreach ($GLOBALS as $k=>$entity)
		{
				
			if(isset($entity->searchFields))
			{
				$this->searchingEntities[$entity->name]=$entity;
			}
		}
	}

	public function search($entityName=null,$keywords)
	{
		if(isset($keywords))
		{
			$results="";
			if(isset($entityName)&&isset($this->searchingEntities[$entityName]))
			{
				$search_conditions=array();

				$entity=$this->searchingEntities[$entityName];

				foreach($keywords as $kwKey=>$keyword)
					$search_conditions[]=$keyword;

				if($entity->search($search_conditions))
				{
					$this->resultsNumber+=sizeof($entity->instances);
					$skin=new Skinlet("search/{$entity->entityName}_search");
					$skin->setContent("instances",$entity->instances);
					$skin->setContent("script_link",$entity->getTextSearchScript());
					$results.=$skin->get();
				}
			}
			else
			{
				foreach($this->searchingEntities as $k=>$entity)
				{
					$search_conditions=array();


					foreach($keywords as $kwKey=>$keyword)
						$search_conditions[]=$keyword;

					if($entity->search($search_conditions))
					{
						$this->resultsNumber+=sizeof($entity->instances);
						$skin=new Skinlet("search/{$entity->entityName}_search");
						$skin->setContent("instances",$entity->instances);
						$skin->setContent("script_link",$entity->getTextSearchScript());
						$results.=$skin->get();
					}

				}
			}
		}
		return $results;
	}
}
?>