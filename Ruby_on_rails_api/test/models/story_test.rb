require 'test_helper'

class StoryTest < ActiveSupport::TestCase
  def setup
    @user = users(:johndoe)
    # This code is not idiomatically correct.
    #@story = Story.new(title: "Lorem ipsum", description: "Hello")
    @story = @user.stories.build(title: "Lorem ipsum", description: "Hello")
  end

  test "should be valid" do
    assert @story.valid?
  end

  test "user id should be present" do
    @story.user_id = nil
    assert_not @story.valid?
  end

  test "description should be present" do
    @story.description = "   "
    assert_not @story.valid?
  end

  test "content should be at most 200 characters" do
    @story.description = "a" * 201
    assert_not @story.valid?
  end
end
