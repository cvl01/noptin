<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Optin Class.
 *
 * All properties are run through the noptin_form_{$property} filter hook
 *
 * @see noptin_get_optin_form
 *
 * @class    Noptin_Form
 * @version  1.0.5
 */
class Noptin_Form {

	//Form id
	protected $id = null;

	/**
	 * Form information
	 * @since 1.0.5
	 * @var array
	 */
	protected $data = array();

	/**
	 * Class constructor. Loads form data.
	 * @param mixed $form Form ID, array, or Noptin_Form instance
	 */
	public function __construct( $form = false ) {

        //If this is an instance of the class...
		if ( $form instanceof Noptin_Form ) {
			$this->init( $form->data );
			return;
        }
        
        //... or an array of form properties
        if ( is_array( $form ) ) {
			$this->init( $form );
			return;
		}

		//Try fetching the form by its post id
		if ( ! empty( $form ) && is_numeric( $form ) ) {
			$form = absint( $form );

			if ( $data = $this->get_data_by( 'id', $form ) ) {
				$this->init( $data );
				return;
			}
		}


		//If we are here then the form does not exist
		$this->init( $this->get_defaults() );
	}

	/**
	 * Sets up object properties
	 *
	 * @param array $data contains form details
	 */
	public function init( $data ) {

		$data 				= $this->sanitize_form_data( $data );
		$this->data 		= apply_filters( "noptin_get_form_data", $data, $this );
		$this->id 			= $data['id'];

	}

	/**
	 * Fetch a form from the db/cache
	 *
	 *
	 * @param string $field The field to query against: At the moment only ID is allowed
	 * @param string|int $value The field value
	 * @return array|false array of form details on success. False otherwise.
	 */
	public function get_data_by( $field, $value ) {

		// 'ID' is an alias of 'id'...
		if ( 'id' == strtolower($field) ) {

			// Make sure the value is numeric to avoid casting objects, for example, to int 1.
			if ( ! is_numeric( $value ) ) {
                return false;
            }
            
            //Ensure this is a valid form id
			$value = intval( $value );
			if ( $value < 1 ) {
                return false;
            }
				
		} else {
			return false;
		}

		//Maybe fetch from cache
		if ( $form = wp_cache_get( $value, 'noptin_forms' ) ) {
            return $form;
        }
        
		//Fetch the post object from the db
		$post = get_post( $value );
        if(! $post || $post->post_type != 'noptin-form' ) {
            return false;
		}
	
        //Init the form
        $form = array(
            'optinName'     => $post->post_title,
            'optinStatus'   => $post->post_status,
            'id'            => $post->ID,
            'optinHTML'     => $post->post_content,
            'optinType'     => get_post_meta( $post->ID, '_noptin_optin_type', true ),
        );

        $state = get_post_meta( $post->ID, '_noptin_state', true );
        if(! is_array( $state ) ) {
            $state = array();
        }

        $form = array_replace( $state, $form );

		//Update the cache with out data
		wp_cache_add( $post->ID, $form, 'noptin_forms' );

		return $this->sanitize_form_data( $form );
    }
    
    /**
	 * Return default object properties
	 *
	 * @param array $data contains form props
	 */
	public function get_defaults() {

		$defaults = array(
			'optinName'                     => __( 'Untitled', 'noptin'),
			'optinStatus'                   => 'draft',
			'id'                            => null,
            'optinHTML'                     => '',
            'optinType'                     => 'popup',

            //Opt in options
            'formRadius'                    => '0px',
            'hideCloseButton'               => false,
            'closeButtonPos'                => 'inside',
           
            'singleLine'                    => true,
            'buttonPosition'                => 'block',
            'showNameField'                 => false,
            'requireNameField'              => false,
            'firstLastName'                 => false,
            'subscribeAction'               => 'message', //close, redirect
            'successMessage'                => 'Thank you for subscribing to our newsletter',
            'redirectUrl'                   => '',
            

            //Form Design
            'noptinFormBg'                  => '#2196f3',
            'noptinFormBorderColor'         => '#2196f3',
            'noptinFormBorderRound'         => true,
            'formWidth'                     => '520px',
            'formHeight'                    => '250px',

            //image Design
            'image'                         => '',
            'imagePos'                      => 'left',

            //Button designs
            'noptinButtonBg'                => '#fafafa',
            'noptinButtonColor'             => '#2196F3',
            'noptinButtonLabel'             => 'SUBSCRIBE',

            //Title design
            'hideTitle'                     => false,
            'title'                         => 'Subscribe To Our Newsletter',
            'titleColor'                    => '#fafafa',

            //Description design
            'hideDescription'               => false,
            'description'                   => 'Join our mailing list to receive the latest news and updates from our team.',
            'descriptionColor'              => '#fafafa',

            //Note design
            'hideNote'                      => true,
            'note'                          => 'Your privacy is our priority',
            'noteColor'                     => '#d8d8d8',
            'hideOnNoteClick'               => false,

            //Trigger Options
            'enableTimeDelay'               => false,
            'timeDelayDuration'             => 10,
            'enableExitIntent'              => false,
            'enableScrollDepth'             => false,
            'scrollDepthPercentage'         => 25,
            'hideOnMobile'                  => true,
            'DisplayOncePerSession'         => true,
            'triggerOnClick'                => false,
            'cssClassOfClick'               => '',
            'triggerAfterCommenting'        => false,
            'displayImmeadiately'           => true,

            //Restriction Options
            'showEverywhere'                   	=> false,
            'showHome'              			=> true,
            'showBlog'                   		=> true,
            'showSearch'                   		=> false,
			'showArchives'              		=> false,
			'neverShowOn'              			=> array(),
			'onlyShowOn'              			=> array(),
			'whoCanSee'              			=> 'all',
			'userRoles'              			=> array(),
			'hideSmallScreens'              	=> false,
			'hideMediumScreens'              	=> false,
			'hideLargeScreens'              	=> false,

            //custom css                    
            'CSS'                           => ' /*Custom css*/ ',

		);
		
		foreach( noptin_get_post_types() as $name => $label ) {
            $defaults["showOn$name"] = ( 'post' == $name );
        }
        
        return $defaults;

	}

	/**
	 * Sanitizes form data
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return array the sanitized data
	 */
	public function sanitize_form_data( $data ) {

		$defaults = $this->get_defaults();

		//Arrays only please
		if (! is_array( $data ) )
			return $defaults;

        $data   = array_replace( $defaults, $data );
        $return = array();

        foreach( $data as $key => $value ){

            if( 'false' === $value ) {
                $return[$key] = false;
                continue;
            }

            if( 'true' === $value ) {
                $return[$key] = true;
                continue;
			}
			
			if( is_array( $defaults[$key] ) && !is_array( $data[$key] ) ) {
				$return[$key] = $defaults[$key];
                continue;
			}

            $return[$key] = $value;
        }

        if( empty( $return['optinType'] ) ) {
            $return['optinType'] = 'popup';
        }

		return $return;
	}

	/**
	 * Magic method for checking the existence of a certain custom field.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return bool Whether the given form field is set.
	 */
	public function __isset( $key ) {

		if ( 'id' == strtolower( $key ) ) {
			return $this->id != null;
        }
		return isset( $this->data[$key] ) && $this->data[$key] != null;

	}

	/**
	 * Magic method for accessing custom fields.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @param string $key form property to retrieve.
	 * @return mixed Value of the given form property 
	 */
	public function __get( $key ) {

		if ( 'id' == strtolower( $key ) ) {
			return apply_filters( "noptin_form_id", $this->id, $this );
		}

		$value = $this->data[$key];

		return apply_filters( "noptin_form_{$key}", $value, $this );
	}

	/**
	 * Magic method for setting custom form fields.
	 *
	 * This method does not update custom fields in the database. It only stores
	 * the value on the Noptin_Form instance.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 */
	public function __set( $key, $value ) {

		if ( 'id' == strtolower( $key ) ) {

			$this->id = $value;
			$this->data['id'] = $value;
			return;

		}

		$this->data[$key] = $value;

	}

	/**
	 * Saves the current form to the database
	 *
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 */
	public function save() {

		if( isset( $this->id ) ) {
            $id = $this->update();
        } else {
            $id = $this->create();
        }

        if( is_wp_error( $id ) ) {
            return $id;
        }

		
        //Update the cache with our new data
        wp_cache_delete( $id, 'noptin_forms' );
        wp_cache_add($id, $this->data, 'noptin_forms' );
		return true;
    }
    
    /**
	 * Creates a new form
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed True on success. WP_Error on failure
	 */
	private function create() {

        //Prepare the args...
        $args = $this->get_post_array();
		unset( $args['ID'] );

        //... then create the form
        $id = wp_insert_post( $args, true );

        //If an error occured, return it
        if( is_wp_error($id) ) {
            return $id;
        }
		
		//Set the new id
		$this->id = $id;

		$state = $this->data;
		unset( $state['optinHTML'] );
		unset( $state['optinType'] );
		unset( $state['id'] );
        update_post_meta( $id, '_noptin_state', $this->data );
        update_post_meta( $id, '_noptin_optin_type', $this->optinType );
        return true;
    }

    /**
	 * Updates the form in the db
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed True on success. WP_Error on failure
	 */
	private function update() {

        //Prepare the args...
        $args = $this->get_post_array();

        //... then update the form
        $id = wp_update_post( $args, true );

        //If an error occured, return it
        if( is_wp_error($id) ) {
            return $id;
        }
        
        $state = $this->data;
		unset( $state['optinHTML'] );
		unset( $state['optinType'] );
		unset( $state['id'] );
        update_post_meta( $id, '_noptin_state', $this->data );
        update_post_meta( $id, '_noptin_optin_type', $this->optinType );
        return true;
    }
    
    /**
	 * Returns post creation/update args
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed
	 */
	private function get_post_array() {
		$data = array(
            'post_title'        => empty( $this->optinName ) ? __( 'Untitled', 'noptin' ) : $this->optinName,
            'ID'                => $this->id,
            'post_content'      => $this->optinHTML,
			'post_status'       => $this->optinStatus,
			'post_type'         => 'noptin-form',
		);
		
		foreach( $data as $key => $val ) {
			if( empty( $val ) ) {
				unset( $data[$key] );
			}
		}

		return $data;
    }
    
    /**
	 * Duplicates the form
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return mixed
	 */
	public function duplicate() {
        $this->optinName = $this->optinName . " (duplicate)";
        $this->id = null;
        return $this->save();
	}

	/**
	 * Determine whether the form exists in the database.
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return bool True if form exists in the database, false if not.
	 */
	public function exists() {
		return null != $this->id;
	}

	/**
	 * Determines whether this form has been published
	 *
	 * @since 1.0.5
	 * @access public
	 *
	 * @return bool True if form is published, false if not.
	 */
	public function is_published() {
		return $this->optinStatus == 'publish';
	}

	/**
	 * Checks whether this is a real form and is saved to the database
	 *
	 * @return bool
	 */
	public function is_form() {
		$is_form = ( $this->exists() && get_post_type( $this->id ) == 'noptin-form' );
		return apply_filters( "noptin_is_form", $is_form, $this );
	}

	/**
	 * Checks whether this form can be displayed on the current page
	 * 
	 *
	 * @return bool
	 */
	public function can_show(){

		//Abort early if the form is not published...
		if( !$this->exists() || !$this->is_published() ) {
			return false;
		}

		//... or the user wants to hide all forms
		if( !empty( $_GET['noptin_hide'] ) && 'true' == $_GET['noptin_hide'] ) {
			return false;
		}
		
		//Get current global post
		$post = get_post();

		//Has the user restricted this to a few posts?
		if(! empty( $this->onlyShowOn ) ) {
			return in_array( $post->ID, $this->onlyShowOn );
		}


		//or maybe forbidden it on this post?
		if( in_array( $post->ID, $this->neverShowOn ) ) {
			return false;
		}

		//Is this form set to be shown everywhere?
		if( $this->showEverywhere ) {
			return true;
		}

		//frontpage
		if ( is_front_page() ) {
			return $this->showHome;
		}

		//blog page
		if ( is_home() ) {
			return $this->showBlog;
		}

		//search 
		if ( is_search() ) {
			return $this->showSearch;
		}
		
		//other archive pages 
		if ( is_archive() ) {
			return $this->showArchives;
		}

		//Single posts
		foreach( noptin_get_post_types() as $name => $label ) {

			//e.g is_singular( post ) for blog post
			if( is_singular( $name ) ) {
				$value = $this->data["showOn$name"];
				return apply_filters( "noptin_form_showOn{$name}", $value, $this );
			}

        }

		return false; //No matching rule
	}

	/**
	 * Returns all form data
	 *
	 * @return array an array of form data
	 */
	public function get_all_data(){
		return $this->data;
	}

}