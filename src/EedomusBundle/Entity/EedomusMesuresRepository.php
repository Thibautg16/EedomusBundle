<?php
/**
 * src/EedomusBundle/Entity/EedomusMesuresRepository.php
 *
 * Copyright 2016 GILLARDEAU Thibaut (aka Thibautg16)
 *
 * Authors :
 *  - Gillardeau Thibaut (aka Thibautg16)
 *
 * Licensed under the Apache License, Version 2.0 (the "License"). 
 * You may not use this file except in compliance with the License. 
 * A copy of the License is located at :
 * 
 * http://www.apache.org/licenses/LICENSE-2.0.txt 
 * 
 * or in the "license" file accompanying this file. This file is distributed 
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either 
 * express or implied. See the License for the specific language governing 
 * permissions and limitations under the License. 
 */ 
 
namespace EedomusBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EedomusMesuresRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EedomusMesuresRepository extends EntityRepository {
	
	public function myMesure($debut, $fin, $periph_id){
	    $queryBuilder = $this->createQueryBuilder('a');
			
		$queryBuilder
		   ->select('a')
		   ->where('a.date BETWEEN :debut AND :fin')
	       ->andWhere('a.periph = :periph_id')
		   ->setParameter('debut', $debut)
		   ->setParameter('fin', $fin)
	       ->setParameter('periph_id', $periph_id)
		   ->orderBy('a.date', 'ASC');
	       
	    // On récupère la Query à partir du QueryBuilder
		$query = $queryBuilder->getQuery();
			
		// On récupère et retourne le resultat
		return $query->getResult();				
	}
}
