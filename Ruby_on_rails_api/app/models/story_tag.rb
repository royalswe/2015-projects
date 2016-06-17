class StoryTag < ActiveRecord::Base
  belongs_to :story
  belongs_to :tag

  # Prevent duplicate tags in story
  validates_uniqueness_of :story_id, :scope => :tag_id
end

