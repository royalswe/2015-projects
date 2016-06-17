class Api::V1::BaseController < ApplicationController
  include Pundit # For authorization rules
  respond_to :xml, :json

  protect_from_forgery with: :null_session
  before_action :destroy_session, :authenticate_developer, :offset_params

  rescue_from ActiveRecord::RecordNotFound, with: :not_found
  rescue_from Pundit::NotAuthorizedError, with: :unauthorized!
  rescue_from ActionController::ParameterMissing, with: :not_found
  rescue_from NoMethodError, with: :not_found

  # Disable cookies (no set-cookies header in response)
  def destroy_session
    request.session_options[:skip] = true
  end

  def authenticate_developer
    if request.headers['Api-Key'].present?
      key = request.headers['Api-Key']

      api_key = Domain.exists?(authentication_token: key)
      response_with('Bad credentials', 401) unless api_key

      @developer = Domain.find_by(authentication_token: key)

    else
      response_with('Not authorized', 403)
    end
  end

  def token
    authenticate_with_http_basic do |email, password|
      user = Creator.find_by(email: email).try(:authenticate, password)
      if user
        respond_to do |format|
          format.json { render json: { token: user.auth_token, username: user.username }, status: 200 }
          format.xml { render xml: { token: user.auth_token }, status: 200 }
        end
      else
        response_with('Bad credentials', 401)
      end
    end
  end

  def authenticate_creator!
    authenticate_with_http_token do |token|
      user = Creator.find_by(auth_token: token)
      response_with('Bade credentials', 401) if user.nil?
      @current_user = user
    end
  end

  def unauthorized!
    respond_to do |format|
      format.json { render json: { error: 'Forbidden, access denied' }, status: 403 }
      format.xml { render xml: { error: 'Forbidden, access denied' }, status: 403 }
    end
  end

  def not_found
    respond_to do |format|
      format.json { render json: { error: '404, not found' }, status: 404 }
      format.xml { render xml: { error: '404, not found' }, status: 404 }
    end
  end

  def response_with (message = 'Bad request', code = 200)
    respond_to do |format|
      format.json { render json: { message: message }, status: code }
      format.xml { render xml: { message: message }, status: code }
    end
  end

  # check if offset/limit is present else set default values
  def offset_params
    offset = 0
    limit = 20
    if query_params[:offset].present?
      @offset = query_params[:offset].to_i
    end
    if query_params[:limit].present?
      @limit = query_params[:limit].to_i
    end
    @offset ||= offset
    @limit ||= limit
  end

  private

  def query_params
    params.permit(:offset, :limit)
  end

end