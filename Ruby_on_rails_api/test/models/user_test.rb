require 'test_helper'

class UserTest < ActiveSupport::TestCase

  def setup
    @user = User.new(username: "Example User", email: "user@example.com", password: "123", password_confirmation: "123")
  end

  test "should be valid" do
    assert @user.valid?
  end

  test "associated stories should be destroyed" do
    @user.save
    @user.stories.create!(title: "Lorem ipsum", description: "Hello")
    assert_difference 'Story.count', -1 do
      @user.destroy
    end
  end
end
