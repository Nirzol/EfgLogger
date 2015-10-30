<?php

namespace Ent\Service;

use Doctrine\Common\Collections\Criteria;
use Zend\Form\Form;

/**
 * Description of ServiceInterface
 *
 * @author egrondin
 */
interface ServiceInterface
{

    public function getAll();

    public function getById($id, $form = null);

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    public function findOneBy(array $criteria, array $orderBy = null);

    public function matching(Criteria $criteria);

    public function insert(Form $form, $dataAssoc);

    public function save(Form $form, $dataAssoc, $entity = null);

    public function delete($id);
}
