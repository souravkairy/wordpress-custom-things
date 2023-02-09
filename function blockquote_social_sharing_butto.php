<!-- When you try to focus your blockquote in your post then you can simply add this code in your functions.php . This code will give you 
a facility to share your qoute in facebook and twitter also contain copy option. Prople can copy the specific quote from the blog.

*note - Please don't edit your themes's function.php. You have to create a clield theme of the main theme. Then install the chield theme 
and modify function.php. If you modify the function of main theme then it will make an effect when you update your theme. So this is 
strictly pohibited. 

Thanks.
Happy coading -->

<?php

function add_font_awesome_cdn() {
  wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.14.0/css/all.css' );
}
add_action( 'wp_enqueue_scripts', 'add_font_awesome_cdn' );

function blockquote_social_sharing_buttons_copy() {
  ?>
  <style>
    .quote {
      position: relative;
      padding: 1em;
      background-color: #f9f9f9;
      border-left: 0.25em solid #ccc;
      margin-bottom: 1em;
    }

    .quote .actions {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      margin-top: 1em;
    }

    .quote .actions .btn {
      display: inline-block;
      margin-right: 0.5em;
      padding: 1px 18px;
      color: #fff;
      border: 0;
      border-radius: 16px;
      cursor: pointer;
    }
    .mr-5 {
      margin-right: 0.5em;
    }
    .quote .actions .fb {
      background-color: #4267B2;
    }

    .quote .actions .fb:hover {
      opacity: 0.8;
    }

    .quote .actions .wh {
      background-color: #25D366;
    }

    .quote .actions .wh:hover {
      opacity: 0.8;
    }
    
    .quote .actions .btn.copy {
      background: linear-gradient(90deg , rgba(253,29,29,1) 27%, rgba(252,176,69,1) 100%);
    }

    .quote .actions .btn.copy:hover {
      opacity: 0.8;
    }

  </style>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.quote .btn.copy').forEach(function(button) {
      button.addEventListener('click', function() {
        var quote = button.closest('.quote').querySelector('p').innerText;
        navigator.clipboard.writeText(quote).then(function() {
          alert('Quote copied to clipboard.');
        });
      });
    });
  });
  </script>

  <?php
}
add_action( 'wp_footer', 'blockquote_social_sharing_buttons_copy' );

function add_social_sharing_buttons_copy_to_blockquote( $content ) {
  $content = preg_replace_callback( '/<blockquote.*?>(.*?)<\/blockquote>/is', function( $matches ) {
    $quote = strip_tags( $matches[1] );
     $quote1 = $matches[1];
    $url = urlencode( get_permalink() );
    $share_links = sprintf(
      '<div class="actions">
      <span class="mr-5">Share-</span>
        <a class="btn fb" href="https://www.facebook.com/sharer/sharer.php?u=%1$s" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a class="btn wh" href="https://api.whatsapp.com/send?text=%2$s%%20%1$s" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <button class="btn copy">COPY</button>
            </div>',
      $url,
      urlencode( $quote )
    );
    return sprintf(
      '<div class="quote">
        <p>%s</p>
        %s
      </div>',
      $quote1,
      $share_links
    );
  }, $content );

  return $content;
}
add_filter( 'the_content', 'add_social_sharing_buttons_copy_to_blockquote' );
