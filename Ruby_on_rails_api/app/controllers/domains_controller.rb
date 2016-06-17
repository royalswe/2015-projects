class DomainsController < ApplicationController
  before_action :logged_in_user
  before_action :correct_user_or_admin, only: :show
  before_action :correct_user_id_or_admin, only: :destroy
  before_action :admin_user, only: :index

  def index
    @domains = Domain.paginate(page: params[:page])
    @users = User.all
  end

  def show
    @user = User.find(params[:id])
    @domains = @user.domains
  end

  def new
    @domain = Domain.new
  end

  def create
    @domain = current_user.domains.build(domain_params)

    if @domain.save
      flash[:success] = "Domain added"
      redirect_to domain_path(current_user)
    else
      render 'new'
    end
  end

  def destroy
    Domain.find(params[:id]).destroy
    flash[:success] = "Domain successfully removed"
    redirect_to(:back)
  end

  private

  def domain_params
    params.require(:domain).permit(:domain_name, :description, :authentication_token)
  end

  # Confirms the correct user from domains or admin
  def correct_user_id_or_admin
    @user = Domain.find(params[:id]).user_id
    redirect_to(root_url) unless current_user.admin? || current_user.id == @user
  end

end
