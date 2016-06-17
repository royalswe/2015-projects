collection @stories

extends "api/v1/stories/show"

############################# with subdomain version #####################################

node(:show_story) { |stories| story_url(stories) }

if @stories.count(:all) == @limit
  node(:next_page){ stories_url(limit: @limit, offset: @limit + @offset) }
end

if @offset > 0
  node(:previous_page){ stories_url(limit: @limit, offset: @offset - @limit) }
end

############################# non subdomain version #####################################

# node(:show_story) { |stories| request.base_url + '/api' + story_path(stories) }
#
# if @stories.count(:all) == @limit
#   node(:next_page){ request.base_url + '/api' + stories_path(limit: @limit, offset: @limit + @offset) }
# end
#
# if @offset > 0
#   node(:previous_page){ request.base_url + '/api' + stories_path(limit: @limit, offset: @offset - @limit) }
# end