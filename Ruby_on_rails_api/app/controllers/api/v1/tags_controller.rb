class Api::V1::TagsController < Api::V1::BaseController

  before_action :authenticate_creator!, only: [:create, :destroy, :update]

  def index
    @tags = Tag.all.limit(@limit).offset(@offset)
  end

  def show
    @tag = Tag.find_by_name(params[:id])
  end

  def destroy
    return unauthorized! unless current_user.admin?

    tag = Tag.find_by_name(params[:id])

    if tag.nil?
      response_with('Tag not found', 404)
    else
      tag.destroy
      response_with('Tag removed', 200)
    end
  end

end