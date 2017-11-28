<?php

/**
 * Get the path to profile pictures from public.
 *
 * @param  string  $path
 * @return string
 */
function profile_picture($path = '')
{
  return '/user-media/profile-pictures'.($path ? '/'.$path : $path);
}

/**
 * Get the path to audio from public.
 *
 * @param  string  $path
 * @return string
 */
function audio($path = '')
{
  return '/user-media/audio'.($path ? '/'.$path : $path);
}

/**
 * Make a random file name.
 * 
 * @param  string $extension
 * @return string
 */

function make_file_name($extension='')
{
  return str_replace('.','0',uniqid('', true)).$extension;
}