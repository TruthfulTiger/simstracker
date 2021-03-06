<?php

class UserMajorController extends Controller {
	private $major;
	private $class;
	private $s2class;
	private $s3class;
	private $s4class;
	private $userID;

	public function __construct() {
		parent::__construct();
		$this->major=new UserMajor($this->db);
		$this->class=new UserClass($this->db);
		$this->s2class=new UserS2Class($this->db);
		$this->s3class=new UserS3Class($this->db);
		$this->s4class=new UserS4Class($this->db);
		$this->userID=$this->f3->get('SESSION.user[2]');
	}


	public function index() {
		$this->major->classes=
			'SELECT COUNT(*) as classcount FROM userclass where usermajor.id = userclass.majorID and userclass.gameVersion > 0 GROUP BY usermajor.id ';
		$this->f3->set('majors',$this->major->getByUserId($this->userID));
		$this->f3->set('title','Majors - '.$this->f3->get('SESSION.user[0]'));
		$this->f3->set('content','usermajor/list.html');
	}

	public function create() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$lastAdded=$this->major->get('_id'); // Store last ID before adding
				$this->major->add();
				$lastID=$this->major->get('_id'); // Store last ID after adding
				if ($lastID!==
					$lastAdded) { // If the two are different, that means a career has been added
					$this->f3->set('SESSION.success','Major has been added.');
				} else {
					$this->f3->set('SESSION.error','Couldn\'t create major.');
				}

				$this->index();
			}
		} else {
			$this->f3->set('title','Create Major');
			$this->f3->set('content','usermajor/create.html');
		}
	}

	public function createClass() {
		if ($this->f3->exists('POST.create')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$id=$this->f3->get('POST.majorID');
				$this->f3->scrub($_POST,'p; br;');
				for ($i=1;$i<=8;$i++) {
					$this->db->exec(
						'INSERT INTO userclass (majorID, userID, gameVersion, semester, classLevel, className) VALUES (:id, :user, :gv, :sem, :clevel, :cname)',
						array(
							':id'=>$id,
							':user'=>$this->userID,
							':clevel'=>$this->f3->get('POST.classLevel'.$i),
							':gv'=>$this->f3->get('POST.gameVersion'.$i),
							':sem'=>$this->f3->get('POST.semester'.$i),
							':cname'=>$this->f3->get('POST.className'.$i)
						)
					);
				}
				$this->index();
			}
		} else {
			$this->major->getById($this->f3->get('PARAMS.id'));
			$major=$this->major;
			$this->f3->set('major',$major);
			$this->f3->set('title','Create Classes for '.$major->majorName);
			$this->f3->set('content','usermajor/class/create.html');
		}
	}

	public function update() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$this->major->edit($this->f3->get('POST.id'));
				$this->f3->set('SESSION.success','Major has been updated.');
				$this->index();
			}
		} else {
			if ($this->f3->exists('PARAMS.id')) {
				$this->major->getById($this->f3->get('PARAMS.id'));
				$this->f3->set('major',$this->major);
				$this->f3->set('title','Update Major');
				$this->f3->set('classes',$this->class->getByMajor($this->major->id));
				$this->f3->set('content','usermajor/update.html');
				$this->f3->set('modified',$this->date);
			} else {
				$this->f3->set('SESSION.error','Major doesn\'t exist');
				$this->index();
			}
		}
	}

	public function updateClass() {
		if ($this->f3->exists('POST.update')) {
			if (!empty($_POST['hptrap'])) {
				die('Nice try, Spam-A-Lot');
			} else {
				$this->f3->scrub($_POST,'p; br;');
				$class=$this->f3->get('POST.id');
				$this->class->getById($class);
				if ($this->class->gameVersion==2)
					$this->s2class->getByClassId($class);
				if ($this->class->gameVersion==3)
					$this->s3class->getByClassId($class);
				if ($this->class->gameVersion==4)
					$this->s4class->getByClassId($class);
				$this->class->edit($class);
				if ($this->class->gameVersion==2)
					$this->s2class->edit($this->s2class->id);
				if ($this->class->gameVersion==3)
					$this->s3class->edit($this->s3class->id);
				if ($this->class->gameVersion==4)
					$this->s4class->edit($this->s4class->id);
				$this->f3->set('SESSION.success','Class has been updated.');
				$this->f3->reroute('/close');
			}
		} else {
			if ($this->f3->exists('PARAMS.id')) {
				$this->class->getById($this->f3->get('PARAMS.id'));
				$this->f3->set('class',$this->class);
				if ($this->class->gameVersion==2) {
					$this->f3->config('config/sims2.cfg');
					$this->s2class->getByClassId($this->f3->get('PARAMS.id'));
					$this->f3->set('s2class',$this->s2class);
				}

				$this->f3->set('title','Update Class');
				$this->f3->set('content','usermajor/class/update.html');
				$this->f3->set('modified',$this->date);
			} else {
				$this->f3->set('SESSION.error','Class doesn\'t exist');
			}
		}
	}


	public function delete() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->major->delete($this->f3->get('PARAMS.id'));
		} else {
			$this->f3->set('SESSION.error','Major doesn\'t exist');
		}

		$this->index();
	}

	public function deleteClass() {
		if ($this->f3->exists('PARAMS.id')) {
			$this->class->delete($this->f3->get('PARAMS.id'));
		} else {
			$this->f3->set('SESSION.error','Class doesn\'t exist');
		}

		$this->index();
	}
}