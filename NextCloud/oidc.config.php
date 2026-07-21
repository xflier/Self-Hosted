<?php
$CONFIG = array ( // copy and paste the following lines into config.php to config OIDC Login

  // docker exec -it nextcloud sh
  // php occ app:enable oidc_login
  
  // --- Core Provider Settings ---
  'oidc_login_provider_url' => 'https://keycloak.self.test/realms/home',
  'oidc_login_client_id' => 'nextcloud',
  'oidc_login_client_secret' => 'secret_to_replaced_in_production',
  'oidc_login_scope' => 'openid profile email',

  // --- Nextcloud 26 Core Integration & Hardening ---
  // Mandatory for NC26 to prevent users from bypassing SSO via regular settings
  'allow_user_to_change_display_name' => false,
  'lost_password_link' => 'disabled',

  // --- Attribute Mappings (Keycloak -> Nextcloud) ---
  'oidc_login_attributes' => array(
      'id' => 'preferred_username',  // NC internal database unique ID
      'mail' => 'email',              // Maps Keycloak 'email' to NC internal 'mail'
      'owncloud_name' => 'name',     // Uses user's Full Name as display name
      'groups' => 'roles',          // Matches group membership mapping
  ),

  // --- Account Provisioning ---
  'oidc_login_disable_registration' => false, // Set to false to auto-create new NC users on first login
  'oidc_create_groups' => false,               // In NC26, set this to true if you want missing Keycloak groups auto-created
  'oidc_login_auto_provision' => true,

  // --- Single Logout (SLO) Flow ---
  'oidc_login_logout_url' => 'https://nextcloud.self.test/apps/oidc_login/oidc',
  'oidc_login_end_session_redirect' => true,

  // --- UI and Intercept Controls ---
  'oidc_login_button_text' => 'Continue with Keycloak',
  'oidc_login_hide_password_form' => true,  // Set to true ONLY after successful validation
  'oidc_login_auto_redirect' => true,        // Set to true to fully bypass the NC login page later
  'oidc_login_redir_fallback' => false,

  // --- Security Options ---
  'oidc_login_tls_verify' => false,
  'oidc_login_use_id_token' => false,         // Uses UserInfo endpoint payload instead of basic ID token payload
);
