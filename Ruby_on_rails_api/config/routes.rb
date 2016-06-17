require 'api_constraints'

Rails.application.routes.draw do
  
  get    'signup'  => 'users#new'
  get    'login'   => 'sessions#new'
  post   'login'   => 'sessions#create'
  delete 'logout'  => 'sessions#destroy'

  # With api as subdomain ex: api.localhost/users
  namespace :api, defaults: {format: :json},
            constraints: { subdomain: 'api' }, path: '/'  do
    scope module: :v1, constraints: ApiConstraints.new(version: 1, default: true) do
      resources :users, :stories, :tags
      post :token, controller: 'base'
    end
  end

  # With api as first parameter ex: localhost:3000/api/users
  namespace :api, defaults: {format: :json} do
    scope module: :v1, constraints: ApiConstraints.new(version: 1, default: true) do
      resources :users, :stories, :tags
      post :token, controller: 'base'
    end
  end

  resources :stories
  resources :users
  resources :domains, except: [:edit, :update]

  root 'sessions#new'

end
