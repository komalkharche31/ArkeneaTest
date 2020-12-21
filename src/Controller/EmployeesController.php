<?php
declare(strict_types=1);

namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Datasource\FactoryLocator;
/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $employees = $this->paginate($this->Employees);

        $this->set(compact('employees'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employee = $this->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
          /*  $postData = $this->request->getData();

             $postImage = $this->request->getData('image');
            $name = $postImage->getClientFilename();
            $type = $postImage->getClientMediaType();
            $targetPath = WWW_ROOT. 'img'. DS . $name;
            if ($type == 'image/jpg' || $type == 'image/png') {
                if (!empty($name)) {
                    if ($postImage->getSize() > 0 && $postImage->getError() == 0) {
                        $postImage->moveTo($targetPath); 
                      $postData['image'] = $name;
                    }
                }
            }
*/
            //print_r($this->request->getData());
            $postData = $this->request->getData();
            $image = $this->request->getData('image');

            $name = $image->getClientFilename();
            $targetpath = WWW_ROOT.'img'.DS.$name;
            if($name){
                     $image->moveTo($targetpath);
                     $postData['image'] = $targetpath;
            }
           
     
           //$employee = $this->Employees->patchEntity($employee, $this->request->getData());
            $employee = $this->Employees->patchEntity($employee, $postData);
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

             $postData = $this->request->getData();
            $image = $this->request->getData('image');

            $name = $image->getClientFilename();
           $targetpath = WWW_ROOT.'img'.DS.$name;
            
            if($name){
                     $image->moveTo($targetpath);
                     $postData['image'] = $name;
            }
           
     
           //$employee = $this->Employees->patchEntity($employee, $this->request->getData());
            $employee = $this->Employees->patchEntity($employee, $postData);
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->Employees->get($id);
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
