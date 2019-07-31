<?php if(!defined('ABSPATH')) { die(); } // This line ensures that the script is not run directly
/**
 * Utility Name: Deploy Gatsby Website
 * Description: call "publish_website.sh" script to build and deploy the gatsby website.
 * Author: Ahmed AbdelRazzak
 * Version: 1.0.0
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 **/

/**
 * Execute the given command by displaying console output live to the user.
 *  @param  string  cmd          :  command to be executed
 *  @return array   exit_status  :  exit status of the executed command
 *                  output       :  console output of the executed command
 */
function liveExecuteCommand($cmd)
{

  while (@ ob_end_flush()); // end all output buffers if any

  $proc = popen("$cmd 2>&1 ; echo Exit status : $?", 'r');

  $live_output     = "";
  $complete_output = "";

  while (!feof($proc))
  {
    $live_output     = fread($proc, 4096);
    $complete_output = $complete_output . $live_output;
    // echo "$live_output";
    @ flush();
  }

  pclose($proc);

  // get exit status
  preg_match('/[0-9]+$/', $complete_output, $matches);

  // return exit status and intended output
  return array (
    'exit_status'  => intval($matches[0]),
    'output'       => str_replace("Exit status : " . $matches[0], '', $complete_output)
  );
}

// this filter contains the actual meat and potatoes of your script
// ---
// $legacy will always be an empty string, but it needed to support a
// legacy version of the utility script format
// ---
// $state is an aritrary value you can return from the previous run of the script,
// and which will be passed through to the next run. One common use is to
// store an offset for paginated database queries. State will be falsy for the
// initial run. It is recommended to store data in state as keys in an array, to
// ensure no overlap with the reserved values of 'complete' and 'error' which
// trigger exiting the script
// ---
// $atts is an array, containing your input form fields, by name, EXCEPT file inputs
// ---
// $files contains an array of any file inputs that were included in the input form
// ---
function deploy_utility_script( $legacy, $state, $atts, $files ) {
  // scripts must return a state and a message, in an array
  // ---
  // if state is not equal to 'complete' or 'error', the script will be
  // triggered again, with state passed to the $state variable.
  // this allows you to create scripts that will take longer than
  // PHP_MAX_EXECUTION_TIME to fully complete
  // ---
  // The contents of message will be output to the user on each run
  $cmd = "/path/to/website/publish_website.sh"; # FIXME: update this path correctly.
  $result = liveExecuteCommand($cmd);
  if($result['exit_status'] === 0){
    // do something if command execution succeeds
    return array(
      'state'   => 'complete',
      'message' => "Succeeded deploying website",
      'logs' => $result["output"],
    );
  } else {
    // do something on failure
    return array(
      'state'   => 'error',
      'message' => "Failed to deploy, please check logs\nLogs:\n" . $result["output"],
      'logs' => $result["output"],
    );
  }
}
add_filter('wp_util_script', 'deploy_utility_script', 10, 4);
