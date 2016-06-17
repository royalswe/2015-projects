class Domain < ActiveRecord::Base
  belongs_to :user

  before_create :generate_authentication_token

  validates :domain_name,
            presence: true,
            length: { maximum: 50 }

  # Generate token to created domain
  def generate_authentication_token
    loop do
      self.authentication_token = SecureRandom.base64(64)
      break unless Domain.find_by(authentication_token: authentication_token)
    end
  end

end

