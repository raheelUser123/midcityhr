<?php
function e($value){ return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function config(){ static $c; return $c ??= require __DIR__.'/config.php'; }
function services(){ static $s; return $s ??= require __DIR__.'/../data/services.php'; }
function service_by_slug($slug){ foreach(services() as $s){ if($s['slug']===$slug) return $s; } return null; }
function page_url($path=''){ return rtrim(config()['site_url'],'/').'/'.ltrim($path,'/'); }
function base_path(){
  $configured = trim((string)(getenv('BASE_PATH') ?: ''), '/');
  if ($configured !== '') return '/'.$configured;
  $script = str_replace('\\','/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
  $known = ['/services/','/articles/','/contact/','/about/','/warranty/','/owner/','/licensed-remodeling-company/','/how-it-works/','/project-gallery/','/service-area/','/privacy-policy/','/reviews/','/realtors/','/property-managers/','/condo-boards/','/investors-landlords/','/api/'];
  foreach($known as $segment){ $pos = strpos($script,$segment); if($pos!==false) return rtrim(substr($script,0,$pos),'/'); }
  $dir = rtrim(dirname($script),'/');
  return $dir==='.' || $dir==='/' ? '' : $dir;
}
function local_url($path=''){ return base_path().'/'.ltrim($path,'/'); }
function rewrite_local_urls($html){
  $base=base_path(); if($base==='') return $html;
  return preg_replace_callback('/\b(href|src|action)=("|\')\/(?!\/)([^"\']*)\2/i',function($m)use($base){return $m[1].'='.$m[2].$base.'/'.$m[3].$m[2];},$html);
}
function csrf_token(){ if(session_status()!==PHP_SESSION_ACTIVE) session_start(); return $_SESSION['csrf'] ??= bin2hex(random_bytes(24)); }
function article_data(){ return require __DIR__.'/../data/articles.php'; }
function render_email_template(array $lead): string {
  ob_start(); include __DIR__.'/email-template.php'; return (string)ob_get_clean();
}
