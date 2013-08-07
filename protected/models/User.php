<?php

    /**
     * This is the model class for table "user".
     *
     * The followings are the available columns in table 'user':
     * @property string     $id
     * @property string     $email
     * @property string     $password
     * @property string     $location
     * @property integer    $is_facebook
     * @property string     $role
     *
     * The followings are the available model relations:
     * @property Category[] $userStyles
     *
     * @method User findByPk
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
                array('password', 'required', 'message' => 'Password cannot be blank'),
                array('password', 'length', 'min' => 3, 'tooShort' => 'Password should be at least 3 characters'),

                array('location', 'required', 'message' => 'Please provide non-empty location', 'on' => 'setLocation'),

                array('is_facebook', 'boolean'),
                array('email, password, location', 'length', 'max' => 100),
                array('role', 'length', 'max' => 15),

                array(
                    'email, password, location',
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
                'location'    => 'Location',
                'is_facebook' => 'Is Facebook',
                'role'        => 'Role',
            );
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