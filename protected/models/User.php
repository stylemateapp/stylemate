<?php

    /**
     * This is the model class for table "user".
     *
     * The followings are the available columns in table 'user':
     * @property string     $id
     * @property string     $email
     * @property string     $password
     * @property Location   $defaultLocation
     * @property integer    $default_location
     * @property integer    $is_facebook
     * @property string     $role
     * @property string     $username
     * @property string     $name
     *
     * The followings are the available model relations:
     * @property Category[] $userStyles
     * @property Location[] $locations
     * @property Location[] $otherLocations
     *
     * @method User findByPk
     * @method User findByAttributes
     */

    class User extends BaseModel
    {
        /**
         * Returns the static model of the specified AR class.
         *
         * @param string $className active record class name.
         *
         * @return User the static model class
         */

        public static function model($className = __CLASS__)
        {
            return parent::model($className);
        }

        /**
         * @return string the associated database table name
         */

        public function tableName()
        {
            return 'user';
        }

        /**
         * @return array
         */

        public function behaviors()
        {
            return array(
                'CAdvancedArBehavior' => array(
                    'class' => 'application.extensions.CAdvancedArBehavior'
                )
            );
        }

        /**
         * @return array validation rules for model attributes.
         */

        public function rules()
        {
            return array(
                array('email', 'required', 'message' => 'Email cannot be blank'),
                array('email', 'email', 'message' => 'Email is invalid'),
                array('email', 'unique', 'message' => 'Email already exists'),

                array('username', 'required', 'message' => 'Username cannot be blank'),
                array('username', 'unique', 'message' => 'Username already exists'),

                array('password', 'required', 'message' => 'Password cannot be blank'),
                array('password', 'length', 'min' => 3, 'tooShort' => 'Password should be at least 3 characters'),

                //array('default_location', 'required', 'message' => 'Please provide non-empty location', 'on' => 'setLocation'),

                array('is_facebook', 'boolean'),
                array('email, password, default_location, username, name', 'length', 'max' => 100),
                array('role', 'length', 'max' => 15),

                array(
                    'email, password, default_location',
                    'filter',
                    'filter' => 'strip_tags'
                ),
            );
        }

        /**
         * @return array relational rules.
         */

        public function relations()
        {
            return array(
                'userStyles' => array(self::MANY_MANY, 'Category', 'user_style(user_id, category_id)'),
                'locations'  => array(self::HAS_MANY, 'Location', 'user_id'),
            );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */

        public function attributeLabels()
        {
            return array(
                'id'          => 'ID',
                'email'       => 'Email',
                'password'    => 'Password',
                'is_facebook' => 'Is Facebook',
                'role'        => 'Role',
            );
        }

        /**
         * Getter for default location
         *
         * @return Location|null
         */

        public function getDefaultLocation()
        {
            $location = Location::model()->findByPk($this->default_location);

            if(!is_null($location)) {

                return $location;
            }

            return null;
        }

        /**
         * Getter for default location
         *
         * @return Location|null
         */

        public function getOtherLocations()
        {
            $locations       = $this->locations;
            $defaultLocation = $this->defaultLocation;

            if (!is_null($defaultLocation)) {

                foreach ($locations as $key => $location) {

                    if ($location->id == $defaultLocation->id) {

                        unset($locations[$key]);
                    }
                }
            }

            return $locations;
        }

        /**
         *
         */

        public function tryToSetDefaultLocation()
        {
            if (empty($this->defaultLocation->name)) {

                if (sizeof($this->locations) > 0) {

                    $this->default_location = $this->locations[0]->id;
                    $this->save(false);
                    $this->refresh();
                }
            }
        }

        /**
         * @return bool
         */

        /*protected function beforeSave()
        {
            if ($this->scenario == 'insert') {

                $salt           = self::blowFishSalt();
                $this->password = $this->encrypt($this->password, $salt);
            }

            return parent::beforeSave();
        }*/

        /**
         * @param $password
         * @param $salt
         *
         * @return string
         */

        public function encrypt($password, $salt)
        {
            $hash = crypt($password, $salt);
            return $hash;
        }

        /**
         * @param int $cost
         *
         * @return string
         * @throws Exception
         * @codeCoverageIgnore
         */

        public static function blowFishSalt($cost = 10)
        {
            if (!is_numeric($cost) || $cost < 4 || $cost > 31) {

                throw new Exception("cost parameter must be between 4 and 31");
            }

            $rand = array();

            for ($i = 0; $i < 8; ++$i) {

                $rand[] = pack('S', mt_rand(0, 0xffff));
            }

            $rand[] = substr(microtime(), 2, 6);
            $rand   = sha1(implode('', $rand), true);
            $salt   = '$2a$' . str_pad((int)$cost, 2, '0', STR_PAD_RIGHT) . '$';

            $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));

            return $salt;
        }
    }