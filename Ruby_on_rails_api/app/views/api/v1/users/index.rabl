collection @users

extends "api/v1/users/show"

node(:user_url) { |users| user_url(users.username) }