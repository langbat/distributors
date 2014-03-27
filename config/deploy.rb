# Deploy PHP-sites using Capistrano

# Usage:
# cap deploy:setup
# cap deploy


# Inspirational URLs:
# http://www.claytonlz.com/index.php/2008/08/php-deployment-with-capistrano/
# http://www.jonmaddox.com/2006/08/16/automated-php-deployment-with-capistrano/

set :application, "winforme"
set :repository,  "git@justwinfor.me:winforme"

# Application Deployment Location
#
# If you aren't deploying to /u/apps/#{application} on the target
# servers (which is the default), you can specify the actual location
# via the :deploy_to variable:
set :deploy_to, "/home/deploy/#{application}"
set :document_root, "/srv/sites/#{application}"

set :scm, :git

set :user, "root"



role :app, "winfor.me"
role :web, "winfor.me"
role :db,  "winfor.me", :primary => true

# SSH data
set :user, "root"

set :use_sudo, false


namespace :deploy do
  task :start do
  end
  task :stop do
  end
  task :restart do
  end
  task :finalize_update do
    run "ln -s #{current_release} /srv/sites/winforme"
    run "touch #{current_release}/production.txt"
    #run "#{current_release}/protected/yiic migrate --interactive=0"
  end

  task :fix do
    run "mkdir #{current_release}/assets"
    run "mkdir #{current_release}/protected/runtime"
    run "chmod -R 0775 #{current_release}"
    run "chown -R www-data:www-data #{current_release}"
  end

end

after "deploy", "deploy:fix"