class Api::V1::StoriesController < Api::V1::BaseController

  before_action :authenticate_creator!, only: [:create, :destroy, :update]

  def index
    if params[:tag].present? # Find by tags
      @stories = Tag.find_by_name(params[:tag]).stories.limit(@limit).offset(@offset)
    elsif params[:location].present? # Find by location
      @stories = Story.near(params[:location], params[:range] ||= 50).limit(@limit).offset(@offset)
    else # Find by search string by title and description. If search is empty it renders all
      @stories = Story.search(params).limit(@limit).offset(@offset)
    end

  end

  def show
    @story = Story.find(params[:id])
  end

  def create
    #abort current_user.inspect
    authorize current_user # check policies/user_policy.rb for auth rules

    story = current_user.stories.new(story_params.except(:tags))

    # add the id from developers api key to know which domain the story belongs to
    story.user_id = @developer.id

    # if tags are present
    if story_params[:tags]
        story_params[:tags].each do |tag|
        # If tag exists then use existing tag name
        if Tag.exists?(tag)
          story.tags << Tag.find_by_name(tag["name"])
        else
          story.tags << Tag.new(tag)
        end
      end
    end

    if story.save
      response_with('Story successfully created', 200)
    else
      response_with('Sorry, could not create story', 400)
    end
  end

  # update story and add new tags if present
  def update
     story = Story.find(params[:id])
     authorize story # check policies/story_policy.rb for auth rules

      if story_params[:tags]
        story_params[:tags].each do |tag|
          # If tag exists then use existing tag name
          if Tag.exists?(tag)
            story.tags << Tag.find_by_name(tag["name"])
          else
            story.tags << Tag.new(tag)
          end
        end
      end

      if story.update(story_params.except(:tags)) && story.save
        response_with('Story successfully saved', 200)
      else
        response_with('Could not update story', 400)
      end
  end

  def destroy
    story = Story.find(params[:id])
    authorize story # check policies/story_policy.rb for auth rules

    if story.destroy
      response_with('Story successfully removed', 200)
    else
      response_with('Could not find story', 404)
    end
  end

  private

  def story_params
    params.require(:story).permit(:title, :description, :address, :longitude, :latitude, tags: [ :name ])
  end

end