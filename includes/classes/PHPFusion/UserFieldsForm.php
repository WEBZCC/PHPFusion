<?php

namespace PHPFusion;

/**
 * Class UserFieldsForm
 *
 * @package PHPFusion
 */
class UserFieldsForm {

    /**
     * @var UserFields
     */
    private $userFields;

    public function __construct( UserFields $userFields ) {
        $this->userFields = $userFields;
    }


    /**
     * User Name input field
     *
     * @return string
     */
    public function usernameInputField() {
        $locale = fusion_get_locale();

        if (iADMIN || $this->userFields->username_change) {

            return form_text( 'user_name', $locale['u127'], $this->userFields->userData['user_name'], [
                'max_length' => 30,
                'required'   => 1,
                'error_text' => $locale['u122'],
                'inline'     => $this->userFields->inputInline
            ] );
        }
        return form_hidden( "user_name", "", $this->userFields->userData["user_name"] );
    }


    /**
     * Shows password input field
     *
     * @return string
     */
    public function passwordInputField() {

        $locale = fusion_get_locale();

        if ($this->userFields->registration || $this->userFields->moderation) {

            return form_text( 'user_password1', $locale['u134a'], '', [
                    'type'             => 'password',
                    'autocomplete_off' => TRUE,
                    'inline'           => $this->userFields->inputInline,
                    'max_length'       => 64,
                    'error_text'       => $locale['u134'] . $locale['u143a'],
                    'required'         => !$this->userFields->moderation,
                    'tip'              => $locale['u147'],
                    'class'            => 'm-b-15'
                ] ) .
                form_text( 'user_password2', $locale['u134b'], '', [
                    'type'             => 'password',
                    'autocomplete_off' => TRUE,
                    'inline'           => $this->userFields->inputInline,
                    'max_length'       => 64,
                    'error_text'       => $locale['u133'],
                    'required'         => !$this->userFields->moderation
                ] );
        }

        return
            form_text( 'user_password', $locale['u135a'], '', [
                'type'             => 'password',
                'autocomplete_off' => TRUE,
                'inline'           => $this->userFields->inputInline,
                'max_length'       => 64,
                'error_text'       => $locale['u133'],
                'class'            => 'm-b-15'
            ] )
            . form_text( 'user_password1', $locale['u134'], '', [
                'type'              => 'password',
                'autocomplete_off'  => TRUE,
                'inline'            => $this->userFields->inputInline,
                'max_length'        => 64,
                'error_text'        => $locale['u133'],
                'tip'               => $locale['u147'],
                'password_strength' => TRUE,
                'class'             => 'm-b-15'
            ] )
            . form_text( 'user_password2', $locale['u134b'], '', [
                'type'             => 'password',
                'autocomplete_off' => TRUE,
                'inline'           => $this->userFields->inputInline,
                'max_length'       => 64,
                'error_text'       => $locale['u133'],
                'class'            => 'm-b-15'
            ] )

            . form_hidden( 'user_hash', '', $this->userFields->userData['user_password'] );

    }

    /**
     * Admin Password - not available for everyone except edit profile.
     *
     * @return string
     */
    public function adminpasswordInputField() {
        $locale = fusion_get_locale();

        if (!$this->userFields->registration && iADMIN && !defined( 'ADMIN_PANEL' )) {

            //$this->userFields->info['user_admin_password'] = form_para( $locale['u131'], 'adm_password', 'profile_category_name' );

            if ($this->userFields->userData['user_admin_password']) {
                // This is for changing password

                return
                    form_text( 'user_admin_password', $locale['u144a'], '', [
                            'type'             => 'password',
                            'autocomplete_off' => TRUE,
                            'inline'           => $this->userFields->inputInline,
                            'max_length'       => 64,
                            'error_text'       => $locale['u136'],
                            'class'            => 'm-b-15'
                        ]
                    )
                    . form_text( 'user_admin_password1', $locale['u144'], '', [
                            'type'              => 'password',
                            'autocomplete_off'  => TRUE,
                            'inline'            => $this->userFields->inputInline,
                            'max_length'        => 64,
                            'error_text'        => $locale['u136'],
                            'tip'               => $locale['u147'],
                            'password_strength' => TRUE,
                            'class'             => 'm-b-15'
                        ]
                    )
                    . form_text( 'user_admin_password2', $locale['u145'], '', [

                            'type'             => 'password',
                            'autocomplete_off' => TRUE,
                            'inline'           => $this->userFields->inputInline,
                            'max_length'       => 64,
                            'error_text'       => $locale['u136'],
                            'class'            => 'm-b-15'
                        ]
                    );

            }

            // This is just setting new password off blank records
            return form_text( 'user_admin_password', $locale['u144'], '', [
                        'type'              => 'password',
                        'autocomplete_off'  => TRUE,
                        'password_strength' => TRUE,
                        'inline'            => $this->userFields->inputInline,
                        'max_length'        => 64,
                        'error_text'        => $locale['u136'],
                        'ext_tip'           => $locale['u147'],
                        'class'             => 'm-b-15'

                    ]
                ) .
                form_text( 'user_admin_password2', $locale['u145'], '', [
                        'type'             => 'password',
                        'autocomplete_off' => TRUE,
                        'inline'           => $this->userFields->inputInline,
                        'max_length'       => 64,
                        'error_text'       => $locale['u136'],
                        'class'            => 'm-b-15'
                    ]
                );
        }
        return '';
    }

    /**
     * Email input
     *
     * @return string
     */
    public function emailInputField() {
        $locale = fusion_get_locale();
        $ext_tip = '';
        if (!$this->userFields->registration) {
            $ext_tip = (iADMIN && checkrights( 'M' )) ? '' : $locale['u100'];
        }

        return form_text( 'user_email', $locale['u128'], $this->userFields->userData['user_email'], [
            'type'       => 'email',
            "required"   => TRUE,
            'inline'     => $this->userFields->inputInline,
            'max_length' => '100',
            'error_text' => $locale['u126'],
            'ext_tip'    => $ext_tip
        ] );


        /*
        add_to_jquery("
        var current_email = $('#user_email').val();
        $('#user_email').on('input change propertyChange paste', function(e){
            if (current_email !== $(this).val()) {
                $('#user_password_verify-field').removeClass('display-none');
            } else {
            $('#user_password_verify-field').addClass('display-none');
            }
        });
        ");
        */

    }

    public function emailHideInputField() {
        $locale = fusion_get_locale();

        return form_checkbox( 'user_hide_email', $locale['u051'], $this->userFields->userData['user_hide_email'], [
            'inline'  => FALSE,
            'toggle'  => TRUE,
            'ext_tip' => $locale['u106']
        ] );
    }

    public function phoneHideInputField() {
        $locale = fusion_get_locale();

        return form_checkbox( 'user_hide_phone', $locale['u107'], $this->userFields->userData['user_hide_phone'], [
            'inline'  => FALSE,
            'toggle'  => TRUE,
            'ext_tip' => $locale['u108']
        ] );
    }


    /**
     * Avatar input
     *
     * @return string
     */
    public function avatarInput() {

        // Avatar Field
        if (!$this->userFields->registration) {
            $locale = fusion_get_locale();

            if (isset( $this->userFields->userData['user_avatar'] ) && $this->userFields->userData['user_avatar'] != "") {

                return "<div class='row'><div class='col-xs-12 col-sm-3'>
                        <strong>" . $locale['u185'] . "</strong></div>
                        <div class='col-xs-12 col-sm-9'>
                        <div class='p-l-10'>
                        <label for='user_avatar_upload'>" . display_avatar( $this->userFields->userData, '150px', '', FALSE, 'img-thumbnail' ) . "</label>
                        <br>
                        " . form_checkbox( "delAvatar", $locale['delete'], '', ['reverse_label' => TRUE] ) . "
                        </div>
                        </div></div>
                        ";
            }

            return form_fileinput( 'user_avatar', $locale['u185'], '', [
                'upload_path'     => IMAGES . "avatars/",
                'input_id'        => 'user_avatar_upload',
                'type'            => 'image',
                'max_byte'        => fusion_get_settings( 'avatar_filesize' ),
                'max_height'      => fusion_get_settings( 'avatar_width' ),
                'max_width'       => fusion_get_settings( 'avatar_height' ),
                'inline'          => $this->userFields->inputInline,
                'thumbnail'       => 0,
                "delete_original" => FALSE,
                'class'           => 'm-t-10 m-b-0',
                "error_text"      => $locale['u180'],
                "template"        => "modern",
                'ext_tip'         => sprintf( $locale['u184'], parsebytesize( fusion_get_settings( 'avatar_filesize' ) ), fusion_get_settings( 'avatar_width' ), fusion_get_settings( 'avatar_height' ) )
            ] );


        }
        return '';

    }

    /**
     * Display Captcha
     *
     * @return string
     */
    public function captchaInput() {

        $locale = fusion_get_locale();

        if ($this->userFields->displayValidation == 1 && !defined( 'ADMIN_PANEL' )) {

            $_CAPTCHA_HIDE_INPUT = FALSE;

            include INCLUDES . "captchas/" . fusion_get_settings( "captcha" ) . "/captcha_display.php";

            $html = "<div class='form-group row'>";
            $html .= "<label for='captcha_code' class='control-label col-xs-12 col-sm-3 col-md-3 col-lg-3'>" . $locale['u190'] . " <span class='required'>*</span></label>";
            $html .= "<div class='col-xs-12 col-sm-9 col-md-9 col-lg-9'>";

            $html .= display_captcha( [
                'captcha_id' => 'captcha_userfields',
                'input_id'   => 'captcha_code_userfields',
                'image_id'   => 'captcha_image_userfields'
            ] );

            if ($_CAPTCHA_HIDE_INPUT === FALSE) {
                $html .= form_text( 'captcha_code', '', '', [
                    'inline'           => 1,
                    'required'         => 1,
                    'autocomplete_off' => TRUE,
                    'width'            => '200px',
                    'class'            => 'm-t-15',
                    'placeholder'      => $locale['u191']
                ] );
            }
            $html .= "</div></div>";
            return $html;
        }

        return '';
    }

    /**
     * Display Terms of Agreement Field
     *
     * @return string
     */
    public function termInput() {

        $locale = fusion_get_locale();
        if ($this->userFields->displayTerms == 1) {
            $agreement = strtr( $locale['u193'], [
                    '[LINK]'  => "<a href='" . BASEDIR . "print.php?type=T' id='license_agreement'><strong>",
                    '[/LINK]' => "</strong></a>"
                ]
            );

            $modal = openmodal( 'license_agreement', $locale['u192'], ['button_id' => 'license_agreement'] );
            $modal .= parse_text( $this->userFields->parseLabel( fusion_get_settings( 'license_agreement' ) ) );
            $modal_content = '<p class="pull-left">' . $locale['u193a'] . ' ' . ucfirst( showdate( 'shortdate', fusion_get_settings( 'license_lastupdate' ) ) ) . '</p>';
            $modal_content .= '<button type="button" id="agree" class="btn btn-success" data-dismiss="modal">' . $locale['u193b'] . '</button>';
            $modal .= modalfooter( $modal_content, TRUE );
            $modal .= closemodal();

            add_to_footer( $modal );

            add_to_jquery( '
            $("#agree").on("click", function() {
                $("#register").attr("disabled", false).removeClass("disabled");
                $("#agreement").attr("checked", true);
            });
            ' );

            $html = "<div class='form-group clearfix'>";
            $html .= "<label class='control-label col-xs-12 col-sm-3 p-l-0'>" . $locale['u192'] . "</label>";
            $html .= "<div class='col-xs-12 col-sm-9'>\n";
            $html .= form_checkbox( 'agreement', $agreement, '', ["required" => TRUE, "reverse_label" => TRUE] );
            $html .= "</div>\n</div>\n";

            add_to_jquery( "
            $('#agreement').bind('click', function() {
                var regBtn = $('#register');
                if ($(this).is(':checked')) {
                    regBtn.attr('disabled', false).removeClass('disabled');
                } else {
                    regBtn.attr('disabled', true).addClass('disabled');
                }
            });
            });" );

            return $html;
        }
        return '';
    }

    /**
     * @return string
     */
    public function renderButton() {

        $disabled = $this->userFields->displayTerms == 1;

        $this->userFields->options += $this->userFields->defaultInputOptions;

//        $html = (!$this->userFields->skipCurrentPass) ? form_hidden( 'user_hash', '', $this->userFields->userData['user_password'] ) : '';

        return form_hidden( $this->userFields->postName, '', 'submit' ) .
            form_button( $this->userFields->postName . '_btn', $this->userFields->postValue, 'submit',
                [
                    "deactivate" => $disabled,
                    "class"      => $this->userFields->options['btn_post_class'] ?? 'btn-primary'
                ] );

    }

}