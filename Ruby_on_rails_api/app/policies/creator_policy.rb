class CreatorPolicy < ApplicationPolicy
  def create?
    return true if user.admin?
    true if record.id == user.id
  end

  def update?
    return true if user.admin?
    true if record.id == user.id
  end

  def destroy?
    return true if user.admin?
    true if record.id == user.id
  end

  class Scope < ApplicationPolicy::Scope
    def resolve
      scope.all
    end
  end
end