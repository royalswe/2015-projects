class SessionsController < ApplicationController

  def create
    user = User.find_by(email: params[:session][:email].downcase)
    if user && user.authenticate(params[:session][:password])
      # Log the user in and redirect to the user's show page.
      log_in user
      redirect_to user
    elsif user.nil?
       flash.now[:danger] = "Email doesn't exist"
       return render 'new'
    else
      flash.now[:danger] = "Invalid email/password combination"
      render 'new'
    end
  end

  def destroy
    log_out
    flash[:success] = "Logged out"
    redirect_to root_url
  end
end
