<?php

$files_to_require = array(
    'about_toggle_widget',
    'side_tabs',
    'resume_sections',
    'research_projects',
    'skills',
    'pricing',
    'our_process',
    'ourteam',
    'thetestimonial',
    'ourservice',
    'ptitles'
);

foreach ($files_to_require as $file) {
    require_once  get_template_directory(). '/inc/widgets/'.$file.'.php';
}